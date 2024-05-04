<script>
    import { createEventDispatcher, onMount } from "svelte";
    import QuestionCard from "../../components/QuestionCard.svelte";
    import Select from "../../../components/select.svelte";
    import Button from "../../../components/button.svelte";

    export let disabled = false;

    let selectedQuestions = [];
    let initialQuestions = [];

    export let questions = [];
    export let sections = [];
    export let assessmentQuestionBanks = [];


    let selectedSection;
    let checkedAll = false;

    const dispatch = createEventDispatcher();

    onMount(() => {

        initialQuestions = questions;
        
    });

    // export let questionCurrentPageNumber
    // export let questionLastPageNumber;

    const selectQuestion = ( questionId ) => {

        selectedQuestions.push(questionId);
        selectedQuestions = selectedQuestions

        dispatch('select-question', { questionId });
    }

    const unselectQuestion = (questionId) => {

        selectedQuestions = selectedQuestions.filter((question) => question != questionId);

        dispatch('deselect-question', { questionId });
    }

    $: disabled = selectedQuestions.length === 0 || initialQuestions.length === 0 

    const checkAll = () => {

       
        if( checkedAll  ){

            dispatch('check-all', { questions: selectedQuestions, checkedAll });

            selectedQuestions = selectedQuestions.filter((q) => ! initialQuestions.some( (s) => q === s.questionId ));


        }else{

            initialQuestions.flatMap((question) => [ question.questionId ]).forEach((sel) => {

                if( ! selectedQuestions.some( (ques) => ques === sel )){

                    selectedQuestions.push(sel);
                }
            })
            
            selectedQuestions = selectedQuestions;

            dispatch('check-all', { questions: selectedQuestions, checkedAll });
        }
    }

    const deleteQuestions = () => {

        disabled = true ; 
        dispatch('delete-questions', { selectedQuestions });

        selectedQuestions = [];
    }

    $: isChecked = (questionId) => selectedQuestions.some((question) => questionId === question );

    $: checkAllDisabled = initialQuestions.length === 0

    $: {
        if( ! selectedSection ){

            initialQuestions = questions;

        }else{
            

            initialQuestions = questions.filter((question) => {

               return question.sectionId === selectedSection
               
            } );
        }
       
    } 

    $: checkedAll = ( ( initialQuestions.filter((q) => selectedQuestions.some( (s) => q.questionId === s)).length ) === initialQuestions.length) && ! (initialQuestions.length === 0)


    const loadMore = (node) => {

       setTimeout(() => {

            const observer = new IntersectionObserver((entries) => {

                if(entries[0].isIntersecting){
                   dispatch('load-more-questions');
                }
            
            }, 
            {
                rootMargin: "100px"
            });

            observer.observe(node);

       }, 500);
    }


    
</script>


<div class="fixed px-8 z-50 w-[calc(100vw-50rem)] min-w-[36rem] h-16 border-b bg-white shrink-0">
    <div class="flex space-x-5 items-center h-full">
        <p class="font-bold text-sm text-gray-800">Sections:</p>
        <Select on:selected={ (e) => selectedSection = e.detail.value } on:deselected={ (e) => selectedSection = null } options={ sections } placeholder="All Sections" className="text-sm"/>
        <p class="text-sm font-bold min-w-max">Total Questions: { initialQuestions.length}</p>

        <div class="flex space-x-2 text-sm">
            <button disabled={ checkAllDisabled } on:click={ checkAll } class="p-2.5 rounded-lg border-2 min-w-max max-w-min border-gray-600 text-gray-600 font-semibold disabled:border-gray-400 disabled:text-gray-400">{ checkedAll ? 'Uncheck All' : 'Check All'}</button>
            <Button on:click={ deleteQuestions } { disabled } buttonText="Delete" className="text-sm" />
        </div>
    </div>

</div>
<div class="fixed pb-16 shrink-0 question mt-16 overflow-y-auto h-[calc(100vh-17rem)] bottom-0 w-[calc(100vw-50rem)] bg-white">
    { #each initialQuestions as question, index }
            <QuestionCard

            checked={ isChecked(question.questionId) }
            showCheckBox={ true }
            sectionTitle={ question.sectionTitle }
            questionId={ question.questionId }
            question={ question.question } 
            questionOptions={ question.options }  
            correctAnswer={ question.correctAnswer } 
            questionNumber={ index + 1 }
            questionScore={ question.questionScore } 
            showOptions={ question.questionType != 'theory' ? true : false }
            on:checked={ (e) => selectQuestion(e.detail.value) }
            on:unchecked={ (e) => unselectQuestion(e.detail.value) }
            >
            <div class="flex space-x-2 pt-5">
                <button on:click={ () => dispatch('edit', question) } class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-xs">Edit</button>
                <button class="px-4 py-2.5 bg-red-500 text-red-50 rounded-lg text-xs">Delete</button>
            </div>
        </QuestionCard> 
    { /each }
    <!-- <div use:loadMore class="h-5 w-full"></div> -->
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
<script>
    import { createEventDispatcher, onMount } from "svelte";
    import QuestionCard from "../../../../components/QuestionCard.svelte";
    import Select from "../../../../../components/select.svelte";
    import Button from "../../../../../components/button.svelte";
    import Icons from "../../../../../components/icons.svelte";

    export let disabled = false;
    export let shouldEditSection = false;

    let selectedQuestions = [];
    let initialQuestions = [];

    export let questions = [];
    export let sections = [];
    // export let assessmentQuestionBanks = [];


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

    const selectSection = (e) => {

        selectedSection = e.detail.value

        dispatch('section-seclected', { section: selectedSection});

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


<div class="fixed inset-y-0 mt-[12rem] px-6 h-16 border-b bg-white shrink-0 right-0 w-[calc(100vw-51rem)] z-50">
    <div class="flex space-x-8 items-center h-full">
        <Select on:selected={ (e) => selectSection(e) } on:deselected={ (e) => { selectedSection = null; dispatch('section-deselected') } } options={ sections } placeholder="All Sections" className="text-sm py-1.5"/>
        <div class="flex items-center space-x-2">
            <Button on:click={ () => dispatch('add-section') } buttonText="Add Section" className="text-xs py-2.5" />
            <Button on:click={ () => dispatch('edit-section') } disabled={ ! shouldEditSection }  buttonText="Edit Section" className="text-xs py-2 bg-white border-2 hover:bg-transparent focus:bg-transparent focus:ring-gray-200 border-gray-600 text-gray-600 font-semibold disabled:border-gray-400 disabled:text-gray-400 disabled:bg-white" />
            <button on:click={ () => { sections = []; selectedSection = null;   dispatch('delete-section')} } disabled={ ! shouldEditSection } class="p-2 rounded-lg min-w-max max-w-min bg-red-600 hover:bg-red-700 font-semibold transition disabled:bg-red-400">
                <Icons  icon="trash" className="stroke-white h-5 w-5" />
            </button>
        </div>
    </div>
</div>
<div class="fixed px-6 h-16 border-b bg-white shrink-0 right-0 w-[calc(100vw-51rem)] inset-y-0 mt-[16rem]">
    <div class="flex space-x-5 items-center h-full w-full justify-between">
        <p class="text-sm font-bold min-w-max text-gray-700">Total Questions: { initialQuestions.length}</p>

        <div class="flex space-x-2 text-sm">
            <button disabled={ checkAllDisabled } on:click={ checkAll } class="p-2 text-xs rounded-lg border-2 min-w-max max-w-min border-gray-600 text-gray-600 font-semibold disabled:border-gray-400 disabled:text-gray-400">{ checkedAll ? 'Uncheck All' : 'Check All'}</button>
            <Button on:click={ () => dispatch('actions') } buttonText="Actions" className="text-xs" />
            <button on:click={ deleteQuestions } { disabled } class="p-2 rounded-lg min-w-max max-w-min bg-red-600 hover:bg-red-700 font-semibold transition disabled:bg-red-400">
                <Icons  icon="trash" className="stroke-white h-5 w-5" />
            </button>
            <!-- <Button on:click={ deleteQuestions } { disabled } buttonText="Delete" className="text-xs py-1 px-6" /> -->
        </div>
    </div>
</div>

<div class="fixed pb-10 right-0 w-[calc(100vw-51rem)] inset-y-0 shrink-0 question bg-white mt-[20rem] overflow-y-auto h-[calc(100vh-20rem)] bottom-0">

    { #if initialQuestions.length === 0 }
        <div class="absolute inset-0 bg-white">
            <div class="container h-[30rem]">
                <div class="flex items-center text-center rounded-lg h-full dark:border-gray-700">
                    <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
                        <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <h1 class="mt-3 text-lg text-gray-800 dark:text-white">No questions found</h1>
                        <p class="mt-2 text-gray-500 dark:text-gray-400">There aren't any available questions.</p>
                    </div>
                </div>
            </div>
        </div>
    { :else }
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
    {/if}
    
    <!-- <div use:loadMore class="h-5 w-full"></div> -->
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
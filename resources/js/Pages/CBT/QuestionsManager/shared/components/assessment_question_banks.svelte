<script>
    import { createEventDispatcher, onMount } from "svelte";
    import QuestionCard from "../../../../components/QuestionCard.svelte";
    import Button from "../../../../../components/button.svelte";
    import Select from "../../../../../components/select.svelte";
    import Icons from "../../../../../components/icons.svelte";
   
    export let disabled = false;

    let selectedQuestions = [];
    let initialQuestions = [];

    export let questions = [];
    export let sections = [];
    export let assessmentQuestionBanks = [];


    let selectedSection;
    let checkedAll = false;

    onMount(() => {

        initialQuestions = questions;
        
    });

    // export let questionCurrentPageNumber
    // export let questionLastPageNumber;

    const dispatch = createEventDispatcher();

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

    const massAssign = () => {

        disabled = true ; 
        dispatch('mass-assign', { selectedQuestions });

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

    
</script>

<!-- <svelte:body on:scroll={ () => console.log('scrolling') } /> -->

<div class="fixed inset-y-0 px-8 z-50 w-[36rem] h-16 border-b border-r bg-white shrink-0 mt-[12rem]">
    <div class="flex space-x-8 items-center h-full justify-between">
        <div class="flex space-x-3 items-center w-full">
            <Select on:selected={ (e) => dispatch('get-question-bank', { value: e.detail.value }) } on:deselected={ (e) => { sections = []; questions = [] } } options={ assessmentQuestionBanks } placeholder="Select Question Bank" className="text-sm py-1.5" optionsStyling="" placeholderStyling=""/>
        </div>
        
       
    </div>
</div>

<div class="fixed inset-y-0 px-8 z-40 w-[36rem] h-16 border-b border-r bg-white shrink-0 mt-[16rem]">
    <div class="flex space-x-4 items-center h-full justify-between">
        <div class="flex space-x-3 items-center w-full">
            <Select on:selected={ (e) => selectedSection = e.detail.value } on:deselected={ (e) => selectedSection = null } options={ sections } placeholder="All Sections" className="text-sm py-1.5 z-50"/>
        </div>
        
        <div class="flex space-x-2 text-sm">
            <button disabled={ checkAllDisabled } on:click={ checkAll } class="p-2 text-xs rounded-lg border-2 min-w-max max-w-min border-gray-600 text-gray-600 font-semibold disabled:border-gray-400 disabled:text-gray-400">{ checkedAll ? 'Uncheck All' : 'Check All'}</button>
            <Button on:click={ massAssign } { disabled } buttonText="Add To Question Bank" className="text-xs" />
        </div>
    </div>
</div>

<div class="fixed w-[36rem] flex flex-col z-30 mt-16 h-[calc(100vh-20rem)] items-center bottom-0 pb-20 border-r question overflow-x-hidden overflow-y-auto bg-white">

    { #if initialQuestions.length === 0 }
       
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
          
    { :else }
         { #each initialQuestions as question, index }
            <QuestionCard 
                showCheckBox
                hasBeenAssigned={ question.isAssigned }
                sectionTitle={ question.sectionTitle }
                questionId={ question.questionId }
                question={ question.question } 
                questionOptions={ question.options }  
                correctAnswer={ question.correctAnswer } 
                questionNumber={ index + 1 }
                questionScore={ question.questionScore } 
                checked={ isChecked(question.questionId) }
                showOptions={ question.questionType != 'theory' ? true : false }
                on:checked={ (e) => selectQuestion(e.detail.value) }
                on:unchecked={ (e) => unselectQuestion(e.detail.value) }
            >
                <div class="flex space-x-2 pt-5">
                    <button on:click={ () => dispatch('edit', question) } class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-xs">Edit</button>
                    <button class="px-4 py-2.5 bg-red-500 text-red-50 rounded-lg text-xs">Delete</button>
                    <!-- <button on:click={ () => dispatch('assign', question) } class="px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-xs">Assign</button> -->
                </div>
            </QuestionCard> 
        { /each }
    {/if}
   
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
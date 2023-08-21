<script>
    import { createEventDispatcher, onMount } from "svelte";
    import Select from "../../components/select.svelte";
    import QuestionCard from "../components/QuestionCard.svelte";


    
    export let hasBeenAssigned;
    export let questionBank = [];

    export let assessmentTypes = [];
    export let subjects = [];
    export let classes = [];
    export let sessions = [];
    export let terms = [];

    const dispatch = createEventDispatcher();

    
</script>


<div class="fixed flex items-center border-b space-x-3 w-[32rem] py-3 px-4 bg-white border-r transition">
    <div class="grid grid-cols-3 gap-2  items-center justify-between w-full "> 
        <div class="w-full max-w-sm">
            <Select options={ assessmentTypes } className="bg-white" placeholder="Assessment Category" />
        </div>
        <div class="w-full max-w-sm">
            <Select options={ assessmentTypes } className="bg-white" placeholder="Assessment type" />
        </div>
        <div class="w-full max-w-sm">
            <Select options={ subjects } className="bg-white"placeholder="Subject" />
        </div>
        <div class="w-full max-w-sm">
            <Select options={ classes } className="bg-white" placeholder="Class" />
        </div>
        <div class="w-full max-w-sm">
            <Select className="bg-white" placeholder="Term" />
        </div>
        <div class="w-full min-w-max">
            <Select options={ sessions } className="bg-white" placeholder="Session" />
        </div>
    </div>
</div>


<div class="pt-28 pb-52 question">
    { #each questionBank as  question, index }
        { #if ! hasBeenAssigned(question.questionId) }  
    
            <QuestionCard 
              question={ question.question } 
              questionOptions={ question.options }  
              correctAnswer={ question.correctAnswer } 
              questionNumber={ index + 1 }
              questionScore={ question.questionScore }>
                <div class="flex space-x-2 pt-5">
                    <button on:click={ () => dispatch('assign', question) }  class="px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-xs">Assign</button>
                </div>
            </QuestionCard>  
        
        {/if}
    { /each }
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
<script>
    import { createEventDispatcher, onMount } from "svelte";
    import QuestionCard from "../components/QuestionCard.svelte";

    export let hasBeenAssigned;
    export let questions = [];

    const dispatch = createEventDispatcher();

    
</script>


<div class="pb-52 question">
    { #each questions as question, index }
        { #if ! hasBeenAssigned(question.questionId) }
            <QuestionCard 
                question={ question.question } 
                questionOptions={ question.options }  
                correctAnswer={ question.correctAnswer } 
                questionNumber={ index + 1 }
                questionScore={ question.questionScore } 
            >
                <div class="flex space-x-2 pt-5">
                    <button on:click={ () => dispatch('edit', question) } class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-xs">Edit</button>
                    <button class="px-4 py-2.5 bg-red-500 text-red-50 rounded-lg text-xs">Delete</button>
                    <button on:click={ () => dispatch('assign', question) } class="px-4 py-2.5 bg-gray-800 text-gray-50 rounded-lg text-xs">Assign</button>
                </div>
            </QuestionCard> 
        {/if}
    {/each}
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
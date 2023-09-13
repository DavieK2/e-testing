<script>
    import { createEventDispatcher, onMount } from "svelte";
    import QuestionCard from "../components/QuestionCard.svelte";
    import Button from "../../components/button.svelte";

    export let hasBeenAssigned;
    export let questions = [];

    export let questionCurrentPageNumber
    export let questionLastPageNumber;

    const dispatch = createEventDispatcher();
    
</script>

<svelte:body on:scroll={ () => console.log('scrolling') } />

<div class="flex flex-col items-center w-full pb-52 question">
    { #each questions as question, index }
        { #if hasBeenAssigned && ! hasBeenAssigned(question.questionId) }
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

    { #if questionCurrentPageNumber != questionLastPageNumber }
        <div class="my-10 max-w-fit">
            <Button on:click={ () => dispatch('load-more-questions') } buttonText="Load More" className="text-sm bg-green-500 focus:ring-green-300 hover:bg-green-600 focus:bg-green-500" />
        </div>
    {/if}
   
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
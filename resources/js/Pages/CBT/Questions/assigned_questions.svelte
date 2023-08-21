<script>
    import { createEventDispatcher } from "svelte";

    
    import QuestionCard from "../components/QuestionCard.svelte";
    export let assignedQuestions = [];

    const dispatch = createEventDispatcher();

</script>

{ #if assignedQuestions.length == 0 }
    <div class="container h-[30rem]">
        <div class="flex items-center text-center rounded-lg h-full dark:border-gray-700">
            <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
                <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h1 class="mt-3 text-lg text-gray-800 dark:text-white">No questions found</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">No question has been assigned to this assessment.</p>
            </div>
        </div>
    </div>
{ :else }
    { #each assignedQuestions as question, index }
        <QuestionCard 
          question={ question.question } 
          questionOptions={ question.options }  
          correctAnswer={ question.correctAnswer } 
          questionNumber={ index + 1 }
          questionScore={ question.questionScore } 
        >
            <div class="flex space-x-2 pt-5">
                <button on:click={ () => dispatch('edit', question) } class="px-4 py-2.5 bg-gray-200 text-gray-700 rounded-lg text-xs">Edit</button>
                <button on:click={ () => dispatch('unassign', question) } class="px-4 py-2.5 bg-red-500 text-red-50 rounded-lg text-xs">Remove</button>
            </div>
        </QuestionCard>  
    { /each }
{ /if }
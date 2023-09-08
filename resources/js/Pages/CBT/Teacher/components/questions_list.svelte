<script>
    import { createEventDispatcher, onMount } from "svelte";
    import QuestionCard from "../../components/QuestionCard.svelte";

    export let questions = [];

    const dispatch = createEventDispatcher();

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


<div class="pb-52 question">
    { #each questions as question, index }
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
        </div>
        </QuestionCard> 
    {/each}
    <div use:loadMore class="h-5 w-full"></div>
</div>

<style>
    .question:empty{
        display: none;
    }
</style>
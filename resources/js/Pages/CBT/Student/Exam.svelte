<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import Qchip from "../components/qchip.svelte";
    import QuestionCard from "./components/QuestionCard.svelte";
    import { router } from "../../../util";

    let questions = [];
    let currentQuestion = 1;

    let selectedColor = "rgb(74 222 128)";
    let notAnsweredColor = "rgb(248 113 113)";
    let markedForReviewColor = "rgb(192 132 252)";
    let markedForReviewAndAnsweredColor = "rgb(250 204 21)";
    let notVisitedColor = "rgb(156 163 175)";
   


    onMount(() => {

        router.get('/api/cbt/session/W9R75mt0', {
            onSuccess : (response) => {
                questions  = response.data.flatMap((question) => {
                    return [
                        {
                            prompt : question.prompt,
                            choices : question.choices,
                            questionId : question.questionId,
                            selectedAnswer: "",
                            notAnswered : false,
                            markedForReview : false,
                            notVisited: true
                        }
                    ];
                });
            }
        })
    })

    $: getQuestionChipStatus = (question) => {

        let color = "";
        let status = "";

        if(question.selectedAnswer.length > 0){
            color = selectedColor ;
            status = "answered"
        }

        if( ! (question.selectedAnswer.length > 0) && question.notAnswered && ! question.markedForReview ){
            color = notAnsweredColor
            status = "notAnswered"
        }

        if(question.markedForReview && ! question.selectedAnswer){
            color = markedForReviewColor
            status = "markedForReview"
        }

        if(question.markedForReview && question.selectedAnswer){
            color = markedForReviewAndAnsweredColor
            status = "markedForReviewAndAnswered"
        }

        if( ! (question.selectedAnswer.length > 0) && question.notVisited && ! question.markedForReview && ! question.notAnswered ){
            color = notVisitedColor
            status = "notVisited"
        }

        return { color, status };
    }

    $: getQuestionStats = (param) => {

        return questions.filter((question) => getQuestionChipStatus(question).status === param ).length.toString();
    }

</script>
<div class="bg-yellow-400 relative min-h-screen w-full">

    <div class="fixed inset-0 flex items-center justify-between h-16 w-full z-50 bg-gray-800 px-8">
        <p class="text-white text-lg font-medium">Assessment Title</p>
        <div class="flex space-x-2">
            <div class="h-9 w-9 bg-gray-700 rounded flex items-center justify-center">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
            </div>
            <div class="h-9 bg-gray-700 rounded flex items-center justify-center px-3 space-x-2">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-white">02:45</p>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 pt-16 flex w-full min-h-screen ">

          <!-- Right Side -->

        <div class="relative flex flex-col flex-1 bg-white border-r">
            <div class="w-full shrink-0  border-b h-16 border-gray-300">
                Something here
            </div>

            <div class="flex flex-col w-full h-[calc(100vh-13rem)] px-8 py-6">
               <div class="w-full h-full overflow-y-auto">
                    <div class="max-w-lg">
                        { #each questions as question, index(question.questionId) }
                            { #if currentQuestion === ( index + 1)}    
                                <QuestionCard { question } questionNumber={ index + 1}  />
                            { /if }
                        { /each }
                    </div>
               </div>
            </div>


            <div class="flex items-center justify-between absolute bottom-0 inset-x-0 bg-white border-t border-b h-20 border-gray-300 px-6">
                <div class="flex space-x-2">
                    <Button buttonText="Clear Answer" className="bg-white text-sm border border-red-500 text-red-500 px-6 hover:bg-red-500 hover:text-white focus:bg-transparent focus:ring-transparent focus:text-red-500" />
                    <Button buttonText="Mark For Review" className="bg-white text-sm border border-yellow-600 text-yellow-600 px-6 hover:bg-yellow-600 hover:text-white min-w-max focus:bg-transparent focus:text-yellow-600 focus:ring-transparent" />
                </div>
                <div>
                    <Button buttonText="Save & Next" className="" />
                </div>
            </div>
        </div>
       


        <!-- Left Side -->
       
        <div class="relative flex flex-col w-96 shrink-0 bg-gray-50">
            <div class="shrink-0 w-full border-b border-gray-300 h-16 bg-white">
Something
            </div>

            <div class="flex flex-col h-[calc(100vh-26rem)] w-full bg-gray-50 px-8 py-6">
                <div class="flex flex-col w-full overflow-y-auto">
                    <div class="grid grid-cols-5 gap-4">
                        { #each questions as question,index }
                            <button>
                                <Qchip color={ getQuestionChipStatus(question).color } qNumber={ "Q" + (index + 1) }  />   
                            </button>
                        {/each}
                    </div>
                </div>                
            </div> 

            <div class="flex items-center justify-between absolute bottom-0 inset-x-0 bg-white border-t h-72 border-gray-300">
               <div class="relative w-full h-full">

                    <div class="flex flex-col justify-center items-center w-full h-full px-8 pt-6 pb-24">
                       <div  class="grid grid-cols-2 w-full gap-4">
                           <div class="flex items-center space-x-2">
                                <Qchip color={ selectedColor } qNumber={ getQuestionStats('answered') } />
                                <span class="text-xs text-gray-700">Answered</span>
                           </div>
                           <div class="flex items-center space-x-2">
                                <Qchip color={ notAnsweredColor } qNumber={ getQuestionStats('notAnswered') } />
                                <span class="text-xs text-gray-700">Not Answered</span>
                           </div>
                           <div class="flex items-center space-x-2">
                                <Qchip color={ markedForReviewColor } qNumber={ getQuestionStats('markedForReview') } />
                                <span class="text-xs text-gray-700">Marked For Review</span>
                           </div>
                           <div class="flex items-center space-x-2">
                                <Qchip color={ markedForReviewAndAnsweredColor } qNumber={ getQuestionStats('markedForReviewAndAnswered') }/>
                                <span class="text-xs text-gray-700">Answered and Marked For Review</span>
                           </div>
                            <div class="flex items-center space-x-2">
                                <Qchip color={ notVisitedColor } qNumber={ getQuestionStats('notVisited') } />
                                <span class="text-xs text-gray-700">Not Visited</span>
                           </div>
                       </div>
                    </div>

                    <div class="flex items-center justify-between absolute bottom-0 inset-x-0 bg-white border-t h-20 border-gray-300 px-6">
                        <Button buttonText="Submit & Finish" className="bg-red-500 text-white hover:bg-red-400 focus:bg-red-500 focus:ring-red-300" />
                    </div>
               </div>
            </div>

        </div>

        
    </div>
    <!-- <div class="fixed inset-0 mt-16 max-w-5xl bg-white border-r border-t border-b h-16 border-gray-300">

    </div>
    <div class="flex fixed inset-0 mt-32 max-w-5xl bg-white border-r border-gray-300">
        he
    </div>
    <div class="flex items-center justify-between fixed bottom-0 inset-x-0 mt-16 max-w-5xl bg-white border-r border-t border-b h-20 border-gray-300 px-6">
        <div class="flex space-x-2">
            <Button buttonText="Clear Answer" className="bg-white text-sm border border-red-500 text-red-500 px-6 hover:bg-red-500 hover:text-white" />
            <Button buttonText="Mark For Review" className="bg-white text-sm border border-yellow-600 text-yellow-600 px-6 hover:bg-yellow-600 hover:text-white min-w-max" />
        </div>
        <div>
            <Button buttonText="Save & Next" className="" />
        </div>
    </div>

    

    <div class="flex fixed right-0 top-0 mt-16 w-96 bg-gray-300  h-16">

    </div>
    <div class="flex fixed inset-0 mt-32 max-w-5xl bg-white border-r border-gray-300">
        he
    </div> -->
</div>
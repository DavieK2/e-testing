<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import Qchip from "../components/qchip.svelte";
    import QuestionCard from "./components/QuestionCard.svelte";
    import { router } from "../../../util";


    export let assessmentId;
    export let assessmentTitle;
    export let subjectId;
    export let timeLeft;

    let isLoading = true;

    let hours = "00";
    let minutes = "00";
    let seconds = "00";

    let questions = [];
    let currentQuestionNumber = 1;
    let currentQuestion;

    let selectedColor = "rgb(74 222 128)";
    let notAnsweredColor = "rgb(248 113 113)";
    let markedForReviewColor = "rgb(192 132 252)";
    let markedForReviewAndAnsweredColor = "rgb(250 204 21)";
    let notVisitedColor = "rgb(156 163 175)";
   


    onMount( async () => {

        let studentResponses;

        await router.get(`/api/cbt/get-responses/student/${assessmentId}`, {
            onSuccess: (res) => {
                studentResponses = res.data;
            }
        })

        startTimer();

        await router.get(`/api/cbt/session/questions/${assessmentId}?subjectId=${subjectId}`, {
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

                if(questions.length > 0){
                    currentQuestion = questions[currentQuestionNumber - 1];
                }

               isLoading = false;
            }
        });

        
    });


    const startTimer = () => {

        const evtSource = new EventSource("/cbt/save-session/student/" + assessmentId, { withCredentials: true});

        evtSource.addEventListener("message", (event) => {

            timeLeft = event.data;
            
            if(timeLeft == 0){
                evtSource.close();
                clearInterval(timer);
            }
        });


        let timer = setInterval(() => {

            hours = Math.floor( timeLeft / ( 60 * 60 ) % 24 ).toString()
            minutes = Math.floor( timeLeft / (60) % 60 ).toString()
            seconds = Math.floor( timeLeft % 60 ).toString()

            hours = hours.padStart(2,"0");
            minutes = minutes.padStart(2,"0");
            seconds = seconds.padStart(2,"0");

            timeLeft --;

        }, 1000);

       
        
    }

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

    const markForReview = () => {
        questions[ currentQuestionNumber - 1 ].markedForReview =  !  questions[ currentQuestionNumber - 1 ].markedForReview;
        // questions = questions
    }

    const setCurrentQuestionNumber = (index) => {
        currentQuestionNumber = index + 1;
    }

    const selectAnswer = (answer) => {
        questions[ currentQuestionNumber - 1 ].selectedAnswer = answer
    }

    const clearAnswer = () => {
        questions[ currentQuestionNumber - 1 ].selectedAnswer = "";
    }

    const submitAnswer = () => {

        let question =  questions[ currentQuestionNumber - 1 ];

        router.post('/api/cbt/save-answer/student/'+assessmentId, { questionId: question.questionId, studentAnswer : question.selectedAnswer, markedForReview : question.markedForReview }, {
            onSuccess : (res) => {

                if(currentQuestionNumber < questions.length){

                    currentQuestionNumber ++ ;
                }
            }
        } );
    }

</script>

{ #if ! isLoading }
    <div class="bg-yellow-400 relative min-h-screen w-full">
        <div class="fixed inset-0 flex items-center justify-between h-16 w-full z-50 bg-gray-800 px-8">
            <p class="text-white text-lg font-medium">{ assessmentTitle }</p>
            <div class="flex space-x-2">
                <div class="h-9 w-9 bg-gray-700 rounded flex items-center justify-center">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                </div>
                <div class="h-9 bg-gray-700 rounded flex items-center justify-center px-3 space-x-2">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-white">{ `${hours} : ${minutes} : ${seconds}`}</p>
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
                                { #if currentQuestionNumber === ( index + 1)}    
                                    <QuestionCard on:selected={ (e) => selectAnswer(e.detail.option) } { question } questionNumber={ index + 1}  />
                                { /if }
                            { /each }
                        </div>
                </div>
                </div>


                <div class="flex items-center justify-between absolute bottom-0 inset-x-0 bg-white border-t border-b h-20 border-gray-300 px-6">
                    <div class="flex space-x-2">
                        <Button on:click={ clearAnswer } buttonText="Clear Answer" className="bg-white text-sm border border-red-500 text-red-500 px-6 hover:bg-red-500 hover:text-white focus:bg-transparent focus:ring-transparent focus:text-red-500" />
                        <Button on:click={ markForReview } buttonText={questions[ currentQuestionNumber - 1 ].markedForReview ? "Unmark For Review" : "Mark For Review"} className="bg-white text-sm border border-yellow-600 text-yellow-600 px-6 hover:bg-yellow-600 hover:text-white min-w-max focus:bg-transparent focus:text-yellow-600 focus:ring-transparent" />
                    </div>
                    <div>
                        <Button on:click={ submitAnswer } buttonText="Save & Next" className="" />
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
                                <button on:click={ () => setCurrentQuestionNumber(index) }>
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
    </div>
{/if}
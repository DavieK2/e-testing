<script>
    import Button from "../../components/button.svelte";
    import Icons from "../../components/icons.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import EditableQuestionCard from "../components/EditableQuestionCard.svelte";
    import QuestionBank from "./question_bank.svelte";
    import AssessmentQuestions from "./assessment_questions.svelte";
    import AssignedQuestions from "./assigned_questions.svelte";
    import { onMount } from "svelte";
    import { router } from "../../../util";
    import { page } from "@inertiajs/svelte";

    let questionType = AssessmentQuestions;

    let showSlidePanel = false;
    let slideTitle = "";
    let edit = false;
    let pageNumber = 1;

    let question = {
        question : "",
        options : ["",""],
        correctAnswer : "",
        questionScore : "",
        source : ""
    };

    let initQuestion = {
        question : "",
        options : ["",""],
        correctAnswer : "",
        questionScore : "",
        source : ""
    };

    let questions = [];
    let questionBank = [];

    let assessmentTypes = [];
    let subjects = [];
    let classes = [];
    let sessions = [];
    let terms = [];

    let assignedQuestions =  [];

    onMount(() => {

        getAssignedQuestions();
        getQuestions();
        getQuestionBank();

        getAssessmentTypes();
        getClasses();
        getSubjects();
        getSessions();
       
    });

    const setQuestionType = (type) => questionType = type;

    const getQuestionBank = () => {

        router.get('/api/question-bank?perPage=15&page='+pageNumber, {
            
            onSuccess : (response) => {
                questionBank = [ ...questionBank, ...response.data ];
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const getAssignedQuestions = () => {

        router.get('/api/questions/' + $page.props.assessmentId + '?assigned=1&perPage=15&page=' + pageNumber, {
            
            onSuccess : (response) => {
                assignedQuestions = [ ...assignedQuestions, ...response.data ];
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const getQuestions = () => {

        router.get('/api/questions/' + $page.props.assessmentId + '?perPage=15&page=' + pageNumber, {
            onSuccess : (response) => {
                questions = [...questions, ...response.data]
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const getAssessmentTypes = () => {

        router.get('/api/assessment-types', {
            onSuccess : (response) => {
                assessmentTypes = response.data.flatMap((type) => [{ placeholder : type.type, value: type.id } ]);
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const getSubjects = async () => {

       await router.get('/api/subjects', {
            onSuccess : (response) => {
                subjects = response.data.flatMap( subject => [{ placeholder : subject.subject_name, value: subject.id } ]);
                
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const getSessions = () => {

        router.get('/api/sessions', {
            onSuccess : (response) => {
                sessions = response.data.flatMap((session) => [{ placeholder : session.session, value: session.id } ]);
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const getClasses = () => {

        router.get('/api/classes', {
            onSuccess : (response) => {
                classes = response.data.flatMap((grade) => [{ placeholder : grade.class_name, value: grade.id } ]);
            },
            onError : (response) => {
                console.log(response)
            }
        })
    }

    const closeSheet = () => {
        showSlidePanel = false
        reset();
    }

    const reset = () => question = initQuestion

    const showSheet = () => showSlidePanel = true
    
    $: hasBeenAssigned = (questionId) => {

        return assignedQuestions.some( (question) => question.questionId == questionId ) ;
    }

    const assignQuestion = (question) => {

        router.post('/api/question/assign/'+$page.props.assessmentId, { questionId : question.questionId }, {

            onSuccess : (response) => {
                 assignedQuestions.push(question);
                 assignedQuestions = assignedQuestions;
            },
            onError : (response) => {
                console.log(response);
            }
        } )
    }

    const unAssignQuestion = (question) => {
        
        router.post('/api/question/unassign/'+$page.props.assessmentId, { questionId : question.questionId }, {

            onSuccess : (response) => {
               
                assignedQuestions =  assignedQuestions.filter( (ques) => ques.questionId != question.questionId );

            },
            onError : (response) => {
                console.log(response);
            }
        } )
    }

    const editQuestion = (ques) => {
        question = ques;
        slideTitle = "Edit Question"
        edit = true;
        showSheet();
    }

    const addQuestion = () => {
       
        slideTitle = "Add New Question"
        edit = false;
        showSheet();
    }

    const updateQuestion = (e) => {

        let questn = e.detail.question;

        questions = questions.map((ques) => ques.questionId === question.questionId ? questn : ques);
        assignedQuestions = assignedQuestions.map((ques) => ques.questionId === question.questionId ? questn : ques);
        

        closeSheet();

    }

    const saveQuestion = (e) => {

        let questn = e.detail.question;

        questions.push(questn);

        questions = questions;
        
        closeSheet();

    }

</script>

<Layout >
   <div class="relative mt-20">
        <div class="fixed ml-56 h-16 z-30 inset-x-0 flex items-center justify-between border-b bg-white">
            <div class="flex space-x-3 items-center py-4 px-8">
                <Icons icon="chart" className="h-5 w-5" />
                <span class="mx-2 text-sm font-medium text-gray-700">Assessments</span>
                <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                <span class="text-sm font-medium text-gray-700">Questions</span>
            </div>
        </div>

        <div class="fixed ml-56 mt-16 z-30 inset-x-0 flex border-b items-center h-16 bg-white">
            <div class="px-8 w-[32rem] shrink-0 border-r h-full">
                <div class="flex items-center justify-center h-full">
                    <button on:click={ () => setQuestionType(AssessmentQuestions) } type="button" class={`text-xs py-2.5 px-8 ${questionType != AssessmentQuestions ? 'text-gray-400 bg-gray-100' : 'text-gray-600 border border-gray-500' } rounded-s-lg transition w-full`}>Questions</button>
                    <button on:click={ () => setQuestionType(QuestionBank) } type="button" class={`text-xs py-2.5 px-8 ${questionType != QuestionBank ? 'text-gray-400 bg-gray-100' : 'text-gray-600 border border-gray-500' } rounded-e-lg transition w-full`}>Question Bank</button> 
                </div>      
            </div>
            <div class="px-8 py-4 min-w-[32rem] flex items-center justify-between w-full">
                <h3 class="text-gray-800 text-sm font-bold min-w-max">Assigned Questions</h3>
                <div>
                    <Button on:click={ addQuestion } buttonText="Add New Question" className="min-w-max text-sm" />
                </div>
            </div>
        </div>
       
        <div class="fixed ml-56 mt-52 w-[32rem] inset-0 bg-white border-r min-h-screen overflow-y-auto">
            <div class="relative flex flex-col h-full">
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
                <div class="absolute z-50 bg-white w-full">
                    <svelte:component on:edit={ (e) => editQuestion(e.detail) } on:assign={ (e) => assignQuestion(e.detail) } this={ questionType } { hasBeenAssigned } { questions } { questionBank } { classes } { sessions } { assessmentTypes } { subjects }  />
                </div>
            </div>
        </div>
        <div class="ml-[46rem] fixed mt-52 min-w-[32rem] shrink-0 inset-0 bg-white min-h-screen overflow-auto">
            <div class="relative flex flex-col h-full">
                <div class="pb-52 max-w-lg">
                    <AssignedQuestions on:edit={ (e) => editQuestion(e.detail) } on:unassign={ (e) => unAssignQuestion(e.detail) } { assignedQuestions } />   
                </div>
            </div>
        </div>
   </div>
</Layout>

<SlidePanel title={ slideTitle } showSheet={ showSlidePanel } on:close-button={ closeSheet } >
   <EditableQuestionCard questionId={ question.questionId } question={ question.question } correctAnswer={ question.correctAnswer } options={ question.options } questionScore={ question.questionScore } { edit } source={ question.source }  on:cancel={ closeSheet } on:updated={ (e) => updateQuestion(e) } on:saved={ (e) => saveQuestion(e) } />
</SlidePanel>


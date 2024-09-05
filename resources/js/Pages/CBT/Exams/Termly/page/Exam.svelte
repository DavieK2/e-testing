<script>
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { router } from "../../../../../util";
    import ExamIntro from "../../components/ExamIntro.svelte";
    import Exam from "../../components/Exam.svelte";


    let hasExamSession = false;
    let assessmentId = $page.props.assessmentId
    let assessmentCode = $page.props.assessmentCode

    let submitModal = false;

    let assessmentTitle = '';
    let assessmentInstructions = '';
    let assessmentDuration;
    let assessmentTotalQuestions;
    let assessmentTotalMarks;
    let timeLeft;
    let studentName;
    let studentCode;
    let studentPhoto;
    let subjectId;
    let studentId;
    let subjectCode;
    let assessmentSession;
    let programOfStudy;
    let level;
    let faculty;
    let department;

    let loading = true;


    onMount( () => {
    

        subjectId =  sessionStorage.getItem('subject'); 

        router.getWithToken(`/api/cbt/t/session/student/${assessmentId}/${subjectId}`, {

            onSuccess: (res) => {

                studentCode = res.data.studentCode;
                hasExamSession = res.data.hasStarted;
                assessmentTitle = res.data.assessmentTitle;
                assessmentInstructions = res.data.instructions;
                assessmentTotalQuestions = res.data.totalQuestions;
                assessmentDuration = res.data.assessmentDuration
                assessmentTotalMarks = res.data.totalScore
                timeLeft = res.data.remainingTime
                studentName = res.data.studentName;
                studentPhoto = res.data.studentPhoto;
                studentId = res.data.studentId;
                subjectCode = res.data.subjectId;
                assessmentSession = res.data.assessmentSession;
                programOfStudy = res.data.programOfStudy;
                level = res.data.level;
                faculty = res.data.faculty;
                department = res.data.department;

                if( assessmentTitle ){
                    setTimeout(() => loading = false, 1000);
                }
            }
        })
    });

    const startAssessment = () => {

        router.postWithToken(`/api/cbt/t/start-session/student/${ assessmentId }/${ subjectId }`,{}, {
            onSuccess : (res) => {
                hasExamSession = true
            }
        }); 
    }

</script>

<svelte:document on:contextmenu|preventDefault />

{ #if loading }

    
    <div class="flex flex-col p-12 items-center justify-center rounded w-full animate-pulse min-h-screen">
      
        <h1 class="max-w-4xl text-center font-extrabold text-5xl text-gray-800">{ assessmentTitle }</h1>
       
    </div>

{ :else }

    { #if hasExamSession }
        <Exam { assessmentCode } { studentName } { assessmentTitle } { studentCode } { studentPhoto } { assessmentId } { timeLeft } { subjectId } { studentId } { subjectCode }  { programOfStudy } { assessmentSession } { level } { faculty } { department } />
    { :else }
        <ExamIntro { assessmentTitle }  { assessmentDuration } { assessmentInstructions } { assessmentTotalMarks } { assessmentTotalQuestions } on:start-assessment={ startAssessment }/>
    {/if}

{/if}


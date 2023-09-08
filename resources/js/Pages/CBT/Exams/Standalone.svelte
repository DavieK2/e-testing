<script>
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { router } from "../../../util";
    import ExamIntro from "../Student/ExamIntro.svelte";
    import Exam from "../Student/Exam.svelte";


    let hasExamSession = false;
    let assessmentId = $page.props.assessmentId

    let assessmentTitle;
    let assessmentInstructions;
    let assessmentDuration;
    let assessmentTotalQuestions;
    let assessmentTotalMarks;
    let timeLeft;

    onMount( () => {
        router.get('/api/cbt/session/student/' + assessmentId, {
            onSuccess: (res) => {
                hasExamSession = res.data.hasStarted;
                assessmentTitle = res.data.assessmentTitle;
                assessmentInstructions = res.data.instructions;
                assessmentTotalQuestions = res.data.totalQuestions;
                assessmentDuration = res.data.assessmentDuration
                assessmentTotalMarks = res.data.totalScore
                timeLeft = res.data.remainingTime
            }
        })
    });

    const startAssessment = () => {

        router.post('/api/cbt/start-session/student/'+assessmentId, {}, {
            onSuccess : (res) => {
                hasExamSession = true
            }
        }); 
    }

</script>

{ #if hasExamSession }
    <Exam { assessmentTitle } { assessmentId } { timeLeft } />
{ :else }
    <ExamIntro { assessmentTitle } { assessmentDuration } { assessmentInstructions } { assessmentTotalMarks } { assessmentTotalQuestions } on:start-assessment={ startAssessment }/>
{/if}


<script>
    import Select from "../../../../../components/select.svelte";
    import Icons from "../../../../../components/icons.svelte";
    import Layout from "../../../../../layouts/Layout.svelte";
    import { onMount } from "svelte";
    import { page, inertia } from "@inertiajs/svelte";
    import { router } from "../../../../../../util";
    import Table from "../../../../../components/table.svelte";
    import Button from "../../../../../components/button.svelte";
    import DataTable from "../../../../../components/data_table.svelte";
    import Tabs from "../../../../../components/tabs.svelte";
    import QuestionBank from "../components/question_bank.svelte";
    import AssessmentQuestionBank from "../components/assessment_question_bank.svelte";


    let assessmentId = $page.props.assessmentId;
    let assessmentTitle = $page.props.assessmentTitle;
    
    let selectedSubject;
    
    let questionBanks = [];
    let subjects = [];

    let tab = AssessmentQuestionBank;
    let tabs = { assessmentQuestionBank: "Assessment Question Bank", lecturerQuestionBank: "Lecturer's Question Bank"}
    let currentTab = tabs.assessmentQuestionBank;

    let headings = ['SN', 'SUBJECT', 'TOTAL QUESTIONS', 'LEVELS', 'LECTURER', 'ACTIONS'];

    onMount(() => {

        router.getWithToken('/api/assessment/question-banks/' + assessmentId, {
            onSuccess : (res) => {
                questionBanks = res.data
            }
        });

        getSubjects();
        
    });

    const getSubjects = () => {

        router.getWithToken('/api/question-bank-subjects/' + assessmentId, {
            onSuccess : (res) => {
                subjects = res.data.flatMap((subject) => [ { placeholder: subject.subjectName, value: subject.subjectCode } ])
            }
        });
    }

    const viewAssessmentQuestions = (subjectId) => {
     
    }

    

    
   
</script>

<Layout>

    <div class="fixed flex items-center h-16 justify-between bg-white py-4 container border-b w-[calc(100vw-15rem)] z-50">
        <div class="flex space-x-2 items-center">
            <span class="mx-2 text-base font-bold text-gray-700 capitalize">Question Banks</span>
            <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
            <span class="mx-2 text-base font-bold text-gray-800">{ assessmentTitle }</span>
        </div>
        <Button on:click={ () => router.navigateTo(`/assessments/termly/question_bank/create/${assessmentId}`)} buttonText="New Question Bank" className="max-w-min min-w-max text-sm font-medium" />
    </div>

   
    <div class="fixed container py-8 h-[calc(100vh-8rem)] w-[calc(100vw-15rem)] bottom-0 overflow-y-auto">
        <div class="flex flex-col justify-start min-h-[24rem] w-full bg-white rounded-lg border  overflow-hidden p-6">
           
            <Tabs on:tab-change={ (e) => { currentTab = e.detail.tab; tab = currentTab == tabs.assessmentQuestionBank ? AssessmentQuestionBank : QuestionBank } } tabs={ Object.values(tabs) } { currentTab } className="text-lg font-bold"/>

            <svelte:component this={ tab } { assessmentId } />
            
        </div>
    </div>
 
</Layout>
<script>
    import Select from "../../../components/select.svelte";
    import Icons from "../../../components/icons.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import Button from "../../../components/button.svelte";
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { router } from "../../../../util";


    let assessmentId = $page.props.assessmentId;
    let selectedClassId;
    let assessmentClasses = [];
    let subjects = [];

    onMount(() => {

        router.get('/api/assessment-classes/' + assessmentId, {
            onSuccess : (res) => {
                assessmentClasses = res.data.flatMap((grade) => [{ placeholder : grade.class_name, value: grade.id, classCode: grade.class_code }] );
            }
        });
        
    });

    const getSubjects = (classId) => {

        selectedClassId = assessmentClasses.filter((grade) => grade.value === classId)[0]?.classCode

        router.get('/api/assessment-subjects/' + assessmentId + "?classId=" + classId, {
            onSuccess : (res) => {
                subjects = res.data
            }
        });
    }

    const viewAssessmentQuestions = (subjectId) => {
        router.navigateTo(`/questions/create/t/${assessmentId}/${subjectId}/${selectedClassId}`);  
    }
</script>

<Layout>
   <div class="container">
        <div class="my-28">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="chart" className="h-6 w-6" />
                    <span class="mx-2 text-lg font-medium text-gray-800">Assessments</span>
                </div>
            </div>
            <div class="flex flex-row justify-start min-h-[24rem] w-full bg-white rounded-lg mt-10 border border-gray-300">
                <div class="flex flex-col items-center min-h-full shrink-0 w-80 border-r border-gray-300 px-5 py-8">
                    <div class="w-full">
                        <Select on:deselected={ () => subjects = [] } on:selected={ (e) => getSubjects(e.detail.value) } options={ assessmentClasses } placeholder="Select Class" className="text-sm py-2.5" />
                    </div>
                </div>
                <div class="flex flex-col px-5 py-8">
                    <p class="font-semibold w-full pb-5 border-b">Subjects</p>
                    <div class="space-y-6 mt-8">
                       { #each subjects as subject, index }
                            <div class={`flex items-center  space-x-4 ${ index != subjects.length - 1 ? 'border-b pb-6' : '' }`}>
                                <div class="text-gray-800 text-sm flex flex-row w-80 shrink-0 items-center">{ subject.subjectName }</div>
                                <Button on:click={ () => viewAssessmentQuestions(subject.subjectId) } buttonText="View Questions" className="text-xs" />
                            </div> 
                       { /each }
                    </div>
                </div>
            </div>
        </div>
   </div>
</Layout>
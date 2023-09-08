<script>
    import { onMount } from "svelte";
    import Icons from "../../components/icons.svelte";
    import Select from "../../components/select.svelte";
    import Layout from "./components/layout.svelte";
    import Button from "../../components/button.svelte";
    import { router } from "../../../util";
    import { page } from "@inertiajs/svelte";


    let assessments = [];
    let assessment;

    let classCode = $page.props.classCode
    let subjectId = $page.props.subjectId

    onMount(() => {
         router.get('/api/published-assessments', {
            onSuccess: (res) => {
                assessments = res.data.flatMap((assessment) => [ { placeholder :  assessment.title , value: assessment.assessmentId }]);
            }
         })
    });

    const createQuestions = () => {

        if(! assessment.value) return ;

        router.navigateTo(`/teacher/questions/${classCode}/${subjectId}/${assessment.value}`);
    }
</script>

<Layout>
    <div class="mt-20 flex items-center justify-between border-b bg-white">
        <div class="flex space-x-3 items-center py-4 px-8">
            <Icons icon="chart" className="h-5 w-5" />
            <span class="mx-2 text-sm font-medium text-gray-700">Questions </span>
            <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
            <span class="text-sm font-medium text-gray-700">Create</span>
        </div>
    </div>
    <div class="w-full mx-auto h-full"> 
        <div class="container max-w-4xl my-12 space-x-10">
            <div class="border bg-white p-8 rounded-lg max-w-8xl">
                <div class="flex items-center justify-between my-2 border-b pb-8">
                    <div>
                        <div class="text-lg font-semibold min-w-max text-gray-700">Assessment</div>
                        <div class="text-gray-400 text-sm">Please select an assessment below</div>
                    </div>
                    
                </div>
        
                <div class="mt-12 space-y-6 w-full">
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Select Assessment</div>
                        <div class="w-full">
                            <Select options={ assessments }  bind:this={ assessment } placeholder={ "Select an Assessment"} className="text-sm py-2.5"  />
                        </div>
                    </div>
                </div>

                <div class="flex w-full mt-10 justify-end">
                    <div class="w-40">
                        <Button on:click={ createQuestions } buttonText="Continue" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</Layout>
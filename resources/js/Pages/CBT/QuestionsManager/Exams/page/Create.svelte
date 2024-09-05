<script>
    import Select from "../../../../../components/select.svelte";
    import Icons from "../../../../../components/icons.svelte";
    import Layout from "../../../../../layouts/Layout.svelte";
    import Button from "../../../../../components/button.svelte";
    import { router } from "../../../../../../util";
    import { page } from "@inertiajs/svelte";
    import { onMount } from "svelte";

    let assessmentTitle = $page.props.assessmentTitle;
    let assessmentId = $page.props.assessmentId;

    let subjectId;
    let subjects = [];
    let classes = [];
    let selectedClasses = []
    let selectAll = false

    let disabled = false


    onMount(() => {
        getSubjects();
    });

    const getSubjects = () => {

        router.getWithToken('/api/question-bank-subjects/' + assessmentId, {
            onSuccess : (res) => {
                subjects = res.data.flatMap((subject) => [ { placeholder: `${subject.subjectName} ( ${subject.subjectCode} )`, value: subject.subjectId } ])
            }
        });
    }

    const getClasses = (subject) => {
        subjectId = subject;
        router.getWithToken(`/api/question-bank-classes/${assessmentId}/${subject}`, {
            onSuccess : (res) => {
                classes = res.data
            }
        });
    }

    $: isSelected = ( gradeId ) => {
        return selectedClasses.some((selected) => selected.class_code == gradeId);
    }

    const selectClass = ( grade ) => {

        if( isSelected(grade.class_code) ){
            selectedClasses = selectedClasses.filter((selected) => selected.class_code != grade.class_code);
            return ;
        }

        selectedClasses.push(grade);
        selectedClasses = selectedClasses;
    }

    
    const selectAllClasses = () => {

        if( selectAll ){

            selectAll = false;
            selectedClasses = []

        }else{

            selectAll = true;
            selectedClasses = classes
        }
    }

    const createQuestionBank = () => {

        disabled = true;

        let classIds = selectedClasses.flatMap( (grade) => [ grade.class_code ]);

        router.postWithToken('/api/question-bank-create?isAssessmentQB=1', { assessmentId, classes: classIds, subjectId }, {
            onSuccess : (res) => {

                router.navigateTo(`/assessments/question_bank/sections/${res.data.questionBankId}`);
            },
            onError : (res) => {
                disabled = false;
            }
        } )
    }
</script>

<Layout>
  
    <div class="fixed flex items-center h-16 justify-between bg-white py-4 container border-b w-[calc(100vw-15rem)] z-50">
        <div class="flex space-x-2 items-center">
            <span class="mx-2 text-base font-bold text-gray-700 capitalize">Question Banks</span>
            <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
            <span class="mx-2 text-base font-bold text-gray-800">{ assessmentTitle }</span>
            <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
            <span class="mx-2 text-base font-bold text-gray-700 capitalize">Create</span>
        </div>
    </div>

    <div class="fixed container py-8 h-[calc(100vh-8rem)] w-[calc(100vw-15rem)] bottom-0 overflow-y-auto">
        <div class="container max-w-4xl my-8">
            <div class="border bg-white p-8 rounded-lg max-w-8xl">
                <div class="flex items-center justify-between my-2 border-b pb-8">
                    <div>
                        <div class="text-2xl font-extrabold min-w-max text-gray-700">Create Question Bank</div>
                        <div class="text-gray-400 text-sm pt-2">Please select relevant course and levels below</div>
                    </div>
                </div>
        
                <div class="mt-12 space-y-6 w-full">
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[12rem] text-gray-700 font-semibold">Select Course</div>
                        <div class="w-full">
                            <Select options={ subjects } on:selected={ (e) => getClasses(e.detail.value) } placeholder={ "Select Course"} className="text-sm py-2.5"  />
                        </div>
                    </div>
                </div>

                <div class="mt-12 space-y-6 w-full">
                    <div class="flex w-full text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[12rem] text-gray-700 font-semibold">Select Levels</span>
                        <div class="w-full space-y-2">
                            { #if classes.length > 0 }
                                <button  on:click={ selectAllClasses } class={`flex items-center shrink-0 justify-center h-12 w-12 border-2 ${ selectAll ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                    <Icons icon="check" className={`${ selectAll ? "stroke-green-700" : "stroke-gray-300" }`} />
                                </button>
                            { /if }
                            
                            { #each classes as grade }
                                <div class="flex space-x-2 items-center w-full">
                                    <button  on:click={ () => selectClass(grade) } class={`flex items-center shrink-0 justify-center h-12 w-12 border-2 ${ isSelected(grade.class_code) ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                        <Icons icon="check" className={`${ isSelected(grade.class_code) ? "stroke-green-700" : "stroke-gray-300" }`} />
                                    </button>
                                    <div class="w-full font-medium">
                                        <button type="button" class={`flex p-3 border-2 ${ isSelected(grade.class_code) ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                            <span class={`${ isSelected(grade.class_code) ? "text-green-700" : "text-gray-400/80" }`} >{ grade.class_name }</span>
                                        </button>
                                    </div>
                                </div>
                            { /each }
                        </div>
                    </div>
                </div>

                <div class="flex w-full mt-10 justify-end">
                    <div class="w-40">
                        <Button on:click={ createQuestionBank } { disabled } buttonText="Continue" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</Layout>
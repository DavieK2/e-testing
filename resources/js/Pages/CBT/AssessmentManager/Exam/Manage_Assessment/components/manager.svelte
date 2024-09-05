<script>
    import Icons from "../../../../../components/icons.svelte";
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";
    import { router } from "../../../../../../util";
    import Dropdown from "../../../../../components/dropdown.svelte";
    import Button from "../../../../../components/button.svelte";


    let assessmentId = $page.props.assessmentId;
    let assessmentTitle = $page.props.assessmentTitle;
    let selectedClassId;
    let classID;
    let assessmentClasses = [];
    let subjects = [];
    let disabled = true;

    onMount( async () => {

       await router.getWithToken('/api/assessment-classes/' + assessmentId, {
            onSuccess : (res) => {
                assessmentClasses = res.data.flatMap((grade) => [{ placeholder : grade.class_name, value: grade.id, classCode: grade.class_code }] );
            }
        });

        if( sessionStorage.getItem('classID') ){

            classID = sessionStorage.getItem('classID');

            getSubjects( classID );
        }
        
    });

    const getSubjects = (classId) => {

        classID = classId;
        
        selectedClassId = assessmentClasses.filter((grade) => grade.value === classId)[0]?.classCode

        router.getWithToken('/api/assessment-subjects/' + assessmentId + "?classId=" + classId, {
            onSuccess : (res) => {
                subjects = res.data
            }
        });

        sessionStorage.setItem('classID', classID);
    }

    const viewAssessmentQuestions = async (subjectId) => {

        await router.navigateTo(`/questions/create/t/${assessmentId}/${subjectId}/${selectedClassId}`);  
    }

    const publishAssesssment = (subject) => {

        let shouldPublish = subject.published ? false : true;


        router.postWithToken('/api/assessment/publish/termly', { subjectId: subject.subjectId, classId: selectedClassId, assessmentId, shouldPublish }, {

            onSuccess: ( res ) => {
                
                getSubjects( classID )
            }
        })
    }
    
    $: disabled = selectedClassId && subjects.length > 0 ? false : true;

</script>


<div class="fixed flex items-center h-16 justify-between px-6 bg-white py-4 border-b w-[calc(100vw-15rem)] z-50">
    <div class="flex space-x-2 items-center">
        <span class="text-base font-medium text-gray-700 capitalize">Manage</span>
        <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
        <span class="mx-2 text-base font-medium text-gray-800">{ assessmentTitle }</span>
    </div>
</div>




        <div class="fixed h-[calc(100vh-8rem)] bottom-0 flex flex-col items-center w-96 border-r bg-white">
            <p class="flex fixed items-center font-extrabold text-lg text-gray-600 border-b px-6 h-16 w-96">Levels</p>
            <div class="fixed mt-10 space-y-3 text-xs px-5 py-10 w-96 h-[calc(100vh-12rem)] bottom-0 overflow-y-auto">
                { #each assessmentClasses as grade, index }
                    <div class="flex space-x-2 items-center w-full">
                        <button  on:click={ () => getSubjects(grade.value) } class={` ${ selectedClassId == grade.classCode ? "border-green-700" : "border-gray-300" } flex items-center shrink-0 justify-center h-[2.5rem] w-[2.5rem] border-2 rounded-lg`}>
                            <Icons icon="check" className={`${ selectedClassId == grade.classCode ? "stroke-green-700" : "stroke-gray-300" }`} />
                        </button>
                        <div class="w-full">
                            <button type="button" class={` ${ selectedClassId == grade.classCode ? "border-green-700" : "border-gray-300" } flex py-2.5 px-3 border-2  w-full rounded-lg items-center justify-between space-x-2`}>
                                <span class={ `${ selectedClassId == grade.classCode ? "text-green-700" : "text-gray-400" } font-medium` }>{ grade.placeholder }</span>
                            </button>
                        </div>
                    </div>
                { /each }
            </div>
        </div>

        <div class="fixed h-[calc(100vh-8rem)] bottom-0 right-0 flex flex-col w-[calc(100vw-39rem)] bg-white">
            <div class="fixed flex items-center justify-between border-b space-x-4 h-16 w-[calc(100vw-39rem)] px-8 bg-white">
                <span class="font-extrabold text-lg text-gray-600">Courses</span>
                <Button { disabled } buttonText="Publish All" className="min-w-max max-w-min text-sm" />
            </div>
            
            <div class="fixed h-[calc(100vh-12rem)] bottom-0 right-0 flex flex-col w-[calc(100vw-39rem)] bg-white space-y-4 pt-8 pb-16 px-8 overflow-y-auto">
                { #if ! selectedClassId }
        
                    <p>Please Select a class</p>
        
                { :else if  selectedClassId && subjects.length === 0 }
        
                    <p>No Subjects assigned for this class</p>
        
                { :else }
        
                    { #each subjects as subject, index }
                        <div class={`flex items-center justify-between  space-x-10 ${ index != (subjects.length - 1) ? 'border-b pb-4' : '' }`}>
                            <div class="text-gray-800 text-sm flex flex-row w-[24rem] items-center text-start">{ subject.subjectName } ( { subject.subjectCode } )</div>
                            <div class={`px-4 py-2 text-center rounded w-[10rem] ${ subject.published  ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' } w-28 text-sm`}>{ subject.published ? 'Published' : 'Unpublished' }</div>
                            <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border  border-gray-300 text-gray-600">
                                <div class="flex flex-col space-y-2 items-start">
                                    <button type="button" on:click={ () => viewAssessmentQuestions(subject.subjectId) } class="text-sm p-2 rounded-lg hover:bg-gray-100 w-full text-left transition">View Questions</button>
                                    <button type="button" on:click={ () => publishAssesssment(subject) } class="text-sm p-2 rounded-lg hover:bg-gray-100 w-full text-left transition">{ subject.published ? 'Unpublish' : 'Publish' }</button>
                                </div>
                            </Dropdown>
                        </div> 
                    { /each }
                { /if }
            </div>
        </div>


   

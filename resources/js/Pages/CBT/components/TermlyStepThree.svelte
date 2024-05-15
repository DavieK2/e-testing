<script>
    import { onMount } from "svelte";
    import Datetimepicker from "../../components/datetimepicker.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import Select from "../../components/select.svelte";
    import { router } from "../../../util";
    import { page } from "@inertiajs/svelte";
    import Button from "../../components/button.svelte";


    let assessmentClasses = [];
    let classSubjects = [];
    let assessmentSubjects = {};
    let selectedSubjects = {};
    let currentClassSubjects = []
    let assessmentId = $page.props.assessmentId;
    let selectedClassId;
    let selectedClassName;
    let hasCache = false;

    let disabled = false

    onMount( () => {
       
        router.getWithToken('/api/assessment-classes/' + assessmentId, {

            onSuccess : async (res) => {

                assessmentClasses = res.data.flatMap((grade) => [{ placeholder : grade.class_name, value: grade.id }] );

                let classIds = assessmentClasses.flatMap((grade => [ grade.value ]));

                await getAssessmentSubjects();

                await getClassSubjects( classIds );

                
            }
        });

    });


    const getAssessmentSubjects = () => {

        if( sessionStorage.getItem('assessmentSubjects') ){

            assessmentSubjects = JSON.parse( sessionStorage.getItem('assessmentSubjects') );

            selectedClassId = sessionStorage.getItem('selectedClassId');

            hasCache = true;
            
            return;

        }

        router.getWithToken('/api/assessment-subjects/' + assessmentId, {

            onSuccess : (res) => {

                assessmentSubjects = res.data;
            }
        });

    }

    const getClassSubjects = async ( classIds ) => {

       await router.postWithToken('/api/class/subject/', { classes: classIds }, {

            onSuccess: (response) => {

                classSubjects = response.data;

                for( let classId in classSubjects ){
                    
                    if( ! assessmentSubjects[classId] ) continue;

                    for ( let subjectId in classSubjects[classId]){

                        if( ! Object.values( assessmentSubjects[classId] )?.some( (selected) => ( selected.subjectId == classSubjects[classId][subjectId].subjectId ) ) )  continue ;

                        classSubjects[classId][subjectId]['isSelected'] = true ;

                    }
                }    
                
                if( selectedClassId ){

                    currentClassSubjects = classSubjects[selectedClassId];
                    selectedSubjects =  assessmentSubjects[selectedClassId] ?? {}

                }
               
            },
            onError: (response) => {

                console.log(response)
            }
        })
    }

    const getCurrenClassSubjects = ( classId, className )=>{

        currentClassSubjects = classSubjects[classId];
        selectedSubjects =  assessmentSubjects[classId] ?? {}

        selectedClassId = classId;
        selectedClassName = className;

        sessionStorage.setItem('selectedClassId', selectedClassId);

    }

    const selectSubject = (subject) => {

        if( ! assessmentSubjects[selectedClassId] ){

            assessmentSubjects[selectedClassId] = {};

        }

        if(  assessmentSubjects[selectedClassId][subject.subjectId] ){

            delete assessmentSubjects[selectedClassId][subject.subjectId];

            classSubjects[selectedClassId][subject.subjectId].isSelected = false;

            currentClassSubjects =  classSubjects[selectedClassId];

            selectedSubjects =  assessmentSubjects[selectedClassId];

            saveToCache();
            
            return;
        }

        assessmentSubjects[selectedClassId][subject.subjectId] = subject;
        assessmentSubjects[selectedClassId][subject.subjectId].published = false

        classSubjects[selectedClassId][subject.subjectId].isSelected = true;

        currentClassSubjects =  classSubjects[selectedClassId];

        selectedSubjects =  assessmentSubjects[selectedClassId];

    }

   
    const onDurationInput = (value, subjectId) => {

        if( assessmentSubjects[selectedClassId][subjectId].duration == value ) return;

        assessmentSubjects[selectedClassId][subjectId].duration = value

        saveToCache();
    }

    const onStartDateInput = (value, subjectId) => {

        if( assessmentSubjects[selectedClassId][subjectId].startDate == value ) return;

        assessmentSubjects[selectedClassId][subjectId].startDate = value;

        saveToCache();
    }

    const onEndDateInput = (value, subjectId) => {

        if( assessmentSubjects[selectedClassId][subjectId].endDate == value ) return;
        
        assessmentSubjects[selectedClassId][subjectId].endDate = value;

        saveToCache();

    }

    const complete = () => {

        disabled = true;

        router.postWithToken('/api/assessment/termly/complete', { assessmentId, subjects: assessmentSubjects, step : "complete_assessment" }, {

            onSuccess : (res) => {

                sessionStorage.removeItem('assessmentSubjects');
                sessionStorage.removeItem('selectedClassId');

                router.navigateTo('/assessments' );
            },
            onError : (res) => {
                disabled = false;
            }
        })
    }

    const saveToCache = () => {

        sessionStorage.setItem('assessmentSubjects', JSON.stringify(assessmentSubjects));
        sessionStorage.setItem('selectedClassId', selectedClassId);

    }

    const clearCache = async  () => {

        sessionStorage.removeItem('assessmentSubjects');
        sessionStorage.removeItem('selectedClassId');
        hasCache = false;

        window.location.reload();
    }

    $: classSubjects = classSubjects


</script>

<div class="w-full px-8 pb-20 container">
    <div class="flex bg-white h-full w-full rounded-lg shadow">
        <div class="w-[24rem] shrink-0 min-h-[20rem] py-8 border-r">
            <div class="flex items-center w-full px-6 text-sm text-gray-600">
                <Select on:deselected={ () => { currentClassSubjects = []; selectedSubjects = {} } } value={ selectedClassId } isSelected={ selectedClassId ? true : false } on:selected={ (e) => getCurrenClassSubjects(e.detail.value, e.detail.placeholder) } options={ assessmentClasses } placeholder={ selectedClassId ? selectedClassName : "Select a Level" } className="text-sm py-2.5" label="Select Level" labelStyle="font-bold text-gray-800 text-base"/>
            </div>
            <div class="p-6 w-full">
               <div class="w-full mt-4">
                    <h3 class="text-gray-800 font-bold pb-4">Courses</h3>
                    <div class="space-y-2">
                        { #if currentClassSubjects.length == 0 }
                            <p class="text-gray-500 italic">No Course Available</p>
                        { :else }
                            <!-- <button  on:click={ selectAllSubjects } class={`flex items-center shrink-0 justify-center h-12 w-12 border-2 ${ selectAll ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                <Icons icon="check" className={`${ selectAll ? "stroke-green-700" : "stroke-gray-300" }`} />
                            </button> -->
                          { #each Object.values(currentClassSubjects) as subject, index(`${selectedClassId}_${subject.subjectId}`) }
                                <div class="flex space-x-2 items-center w-full">
                                    <button  on:click={ () => selectSubject(subject) } class={`flex items-center shrink-0 justify-center h-12 w-12 border-2 ${ subject.isSelected ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                        <Icons icon="check" className={`${ subject.isSelected  ? "stroke-green-700" : "stroke-gray-300" }`} />
                                    </button>
                                    <div class="w-full">
                                        <button type="button" class={ `flex p-3 border-2 ${ subject.isSelected  ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                            <span class={ `text-left text-sm ${ subject.isSelected  ? "text-green-700" : "text-gray-400" }` } >{ subject.subjectName }</span>
                                        </button>
                                    </div>
                                </div>
                          { /each }
                        {/if}
                    </div>
               </div>
            </div>
        </div>
        <div class="relative flex flex-col flex-1 w-full h-full py-8 overflow-auto">
            <div class="flex justify-end w-full px-8 items-center space-x-3">
                { #if hasCache }
                    <div>
                        <span class="text-xs text-gray-500 italic">( Some updates made by you to the schedule have not been saved )</span>
                        <button on:click={ clearCache } class="text-xs text-red-500 border px-3 py-2 rounded border-red-500">Discard Updates</button>
                    </div>
                { /if }
                <Button { disabled } on:click={ complete } buttonText="Save & Complete" className="min-w-max max-w-min" />
            </div>
            <div class="question z-50 subjects px-8 w-full  h-full space-y-6 mt-10">
                { #each Object.values(selectedSubjects) as subject, index(`${selectedClassId}_${subject.subjectId}`) }
                    <div>
                        <h4 class="text-gray-800 text-sm pb-4 font-semibold">{ subject.subjectName }</h4>
                        <div class="flex items-center space-x-8">
                            <div class="w-24">
                                <Input value={ (assessmentSubjects[selectedClassId][subject.subjectId].duration) ?? '' } on:input={ (e) => onDurationInput(e.detail.input, subject.subjectId) } type="number" pattern="[0-9]+" label="Duration" labelStyle="text-sm text-gray-500"  />
                            </div>
                            <div class="w-[16.25rem]">
                                <Datetimepicker value={ (assessmentSubjects[selectedClassId][subject.subjectId].startDate) ?? '' } on:selected={ (e) => onStartDateInput(e.detail.datetime, subject.subjectId) } placeholder="Enter Start Date" showLabel={true} label="Start Date" labelStyling="text-sm font-normal text-gray-500 pt-[7px]"  />
                            </div>
                            <div class="w-[16.25rem]">
                                <Datetimepicker value={ (assessmentSubjects[selectedClassId][subject.subjectId].endDate) ?? '' } on:selected={ (e) => onEndDateInput(e.detail.datetime, subject.subjectId) }  placeholder="Enter End Date" showLabel={true} label="End Date" labelStyling="text-sm font-normal text-gray-500 pt-[7px]"  />
                            </div>
                        </div>
                    </div>
                {/each}
            </div>
            
        </div>
    </div>
</div>
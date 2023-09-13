<script>
    import { onMount } from "svelte";
    import { router } from "../../../../util";
    import Button from "../../../components/button.svelte";
    import Datetimepicker from "../../../components/datetimepicker.svelte";
    import Input from "../../../components/input.svelte";
    import Select from "../../../components/select.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import Icons from "../../../components/icons.svelte";

    let assessmentTitle;
    let assessmentType;
    let duration;
    let startDate;
    let endDate;
    let assessmentDescription;

    let assessmentTitleValue;;
    let assessmentTypeValue = {};
    let durationValue;
    let startDateValue;
    let endDateValue;
    let assessmentDescriptionValue;

    let assessmentId;
    // let assessment;

    let assessmentTypes = [];

    onMount(() => {

        let url = location.href;
        let param = url.split('?')[1];

        let query = new URLSearchParams(param);
        assessmentId = query.get('assessmentId');

        if( assessmentId ){

            router.get('/api/assessment/' + assessmentId, {

                onSuccess : (res) => {
                    
                    let assessment = res.data.assessment;
                   
                    assessmentTitleValue = assessment.title;
                    assessmentDescriptionValue = assessment.description
                    assessmentTypeValue.value = assessment.assessmentTypeId
                    assessmentTypeValue.placeholder = assessment.assessmentType
                    durationValue = assessment.duration;
                    startDateValue = assessment.startDate;
                    endDateValue = assessment.endDate;
                    assessmentDescriptionValue = assessment.description;

                }
            })
        }

        router.get('/api/assessment-types', {
            onSuccess: (response) => {
                assessmentTypes = response.data
                assessmentTypes = assessmentTypes.flatMap((assessmentType) => [{ placeholder : assessmentType.type, value: assessmentType.id } ]);
            }
        });
    })

    const createAssessment = () => {

        let data = {
            step : "create_assessment",
            title : assessmentTitle.value,
            assessmentTypeId : assessmentType.value,
            isStandalone : true,
            duration : duration.value,
            startDate : startDate.datetime,
            endDate : endDate.datetime,
            description : assessmentDescription.value
        }

        router.post('/api/assessment/create', data, {
            onSuccess : (response) => {

                router.navigateTo('/questions/create/s/'+response.data.assessmentId);
            },
            onError : (response) => {

            }
        } )
    }

    const updateAssessment = () => {

        let data = {
            assessmentId,
            step : "create_assessment",
            title : assessmentTitle.value,
            assessmentTypeId : assessmentType.value,
            isStandalone : true,
            duration : duration.value,
            startDate : startDate.datetime,
            endDate : endDate.datetime,
            description : assessmentDescription.value
        }

        router.post('/api/assessment/update', data, {
            onSuccess : (response) => {

                router.navigateTo('/assessments');
            },
            onError : (response) => {

            }
        } )
    }


</script>


<Layout>
    <div class="mt-20 flex items-center justify-between border-b bg-white">
        <div class="flex space-x-3 items-center py-4 px-8">
            <Icons icon="chart" className="h-5 w-5" />
            <span class="mx-2 text-sm font-medium text-gray-700">Assessments </span>
            <Icons icon="chevron_right" fill="#242121EB" className="h-4 w-4" />
            <span class="text-sm font-medium text-gray-700">Create</span>
        </div>
    </div>
    <div class="w-full mx-auto h-full"> 
        <div class="container max-w-4xl my-12 space-x-10">
            <div class="border bg-white p-8 rounded-lg max-w-8xl">
                <div class="flex items-center justify-between my-2 border-b pb-8">
                    <div>
                        <div class="text-2xl font-semibold min-w-max text-gray-700">Assessment Details</div>
                        <div class="text-gray-400 text-sm">Enter assessment details below</div>
                    </div>
                    
                    <div class="ml-72 pt-4 max-w-3xl">
                        { #if assessmentId }
                            <Button on:click={ updateAssessment } buttonText="Update" />
                        { :else }
                            <Button on:click={ createAssessment } buttonText="Create" />
                        { /if }
                    </div>
                </div>
        
                <div class="mt-12 space-y-6 w-full">
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[18rem] text-gray-700">Enter Assessment Title</span>
                        <div class="w-full">
                            <Input value={ assessmentTitleValue } bind:this={ assessmentTitle }  />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Enter Assessment Type</div>
                        <div class="w-full">
                            <Select value={ assessmentTypeValue.value } options={ assessmentTypes } isSelected={ assessmentTypeValue ? true : false } bind:this={ assessmentType } placeholder={ assessmentTypeValue.placeholder ? assessmentTypeValue.placeholder : "Select an Assessment Type"} className="text-sm py-2.5"  />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-3xl">
                        <div class="w-[18rem] flex-shrink-0 text-gray-700">
                            <p>Assessment Duration</p>
                            <small class="text-gray-400">Assessment Duration should be in minutes</small>
                        </div>
                        <div class="w-40">
                            <Input value={ durationValue } bind:this={ duration } type="number" pattern="[0-9]+"  />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-3xl">
                        <div class="w-[18rem] flex-shrink-0 text-gray-700">
                            <p>Enter Assessment Dates</p>
                            <small class="text-gray-400">Choose assessment start date and end date</small>
                        </div>
                        <div class="w-[17.5rem]">
                            <Datetimepicker value={ startDateValue} bind:this={ startDate } placeholder="Enter Start Date"  />
                            <Datetimepicker value={ endDateValue } bind:this={ endDate } placeholder="Enter End Date" />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl pt-4">
                        <label class="w-[18rem] flex-shrink-0 text-gray-700" for="">Enter Assessment Instructions</label>
                        <textarea bind:this={ assessmentDescription } class="border w-full rounded-lg resize-none p-4 border-gray-300" cols="30" rows="5">{ assessmentDescriptionValue ?? '' }</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</Layout>

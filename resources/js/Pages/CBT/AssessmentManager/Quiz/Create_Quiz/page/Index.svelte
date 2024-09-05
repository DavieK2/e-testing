<script>
    import { onMount } from "svelte";
    import { router } from "../../../../../../util";
    import Button from "../../../../../components/button.svelte";
    import Datetimepicker from "../../../../../components/datetimepicker.svelte";
    import Input from "../../../../../components/input.svelte";
    import Select from "../../../../../components/select.svelte";
    import Layout from "../../../../../layouts/Layout.svelte";
    import TopHeader from "../../../../../layouts/top_header.svelte";
    import AppContainer from "../../../../../layouts/app_container.svelte";
    import SlidePanel from "../../../../../components/slide_panel.svelte";
    import { inArray, removeItem } from "../../../../../../helpers";
    import { page } from "@inertiajs/svelte";



    let disabled = false;

    let assessmentTitle;
    let assessmentType;
    let duration;
    let startDate;
    let endDate;
    let assessmentDescription;


    let assessmentId = $page.props.assessmentId;

    let assessmentTypes = [];
    
    let contributorsOptions = [
        { placeholder: "None", value: "none"},
        { placeholder: "All Teachers", value: "all_teachers"},
        { placeholder: "Selected Teachers", value: "selected_teachers"},
    ];
    let quizTakersOptions = [
        { placeholder: "Everyone with quiz link", value: "everyone"},
        { placeholder: "Selected Classess", value: "selected_classes"},
        { placeholder: "Selected Students", value: "selected_students"},
    ];

    let slidePanelStates = {
        selected_teachers   : "Select Teachers",
        selected_classes    : "Select Class",
        selected_students   : "Select Students",
        view_contributors   : "View Contributors",
        view_quiz_takers    : "View Quiz Takers",
    }

    let slidePanelState;

    let selectedContributorsOption  = contributorsOptions[0].value;
    let selectedQuizTakersOption = quizTakersOptions[0].value;

    let isSlidePanelOpen = false;
    let showAddContributorsButton = false;
    let showAddQuizTakersButton = false;
    let shouldDisplayResults = false;
    let shouldGradeWithAssessmentTypeMaxScore = false;
    let shouldShuffleQuestions = false;

    let contributors = [];
    let selectedContributors = [];

    let classQuizTakers = [];
    let studentQuizTakers = [];
    let selectedClassQuizTakers = [];
    let selectedStudentQuizTakers = [];
    let quizTakers = [];

    let classes = [];

    onMount(() => {

        getAssessmentTypes();
        
        if( assessmentId ) getAssessment();
 
    })

    const getAssessmentTypes = () => {

        return router.get('/api/assessment-types', {

            onSuccess: (response) => {
                assessmentTypes = response.data
                assessmentTypes = assessmentTypes.flatMap((assessmentType) => [{ placeholder : assessmentType.type, value: assessmentType.id } ]);
            }

        });
    }

    const getAssessment = () => {

        return router.get(`/api/assessment/quiz/edit/${assessmentId}`, {

            onSuccess : async ( res ) => {
                                    
                assessmentTitle = res.data.title;
                assessmentDescription = res.data.description
                assessmentType = res.data.assessmentTypeId
                duration = res.data.duration;
                assessmentDescription = res.data.assessmentDescription;
                startDate = res.data.startDate;
                endDate = res.data.endDate;
                selectedContributorsOption = res.data.contributorType;                  
                selectedQuizTakersOption = res.data.quizTakerType;                  
                shouldDisplayResults = res.data.shouldDisplayResults;
                shouldGradeWithAssessmentTypeMaxScore = res.data.shouldGradeWithAssessmentTypeMaxScore;
                shouldShuffleQuestions = res.data.shouldShuffleQuestions;
                selectedContributors = res.data.contributors;

                
                if( res.data.quizTakerType === "selected_classes" ){
                    
                    selectedClassQuizTakers = res.data.quizTakers;

                    quizTakers = selectedClassQuizTakers.flatMap( (grade) => [ grade.id ]);;
                }
                

                if( res.data.quizTakerType === "selected_students" ){

                    selectedStudentQuizTakers = res.data.quizTakers;

                    quizTakers = selectedStudentQuizTakers.flatMap( (student) => [ student.studentId ]);
                }

            }
        })
    }

    const createAssessment = () => {

        disabled = true ;

        router.post('/api/assessment/quiz/create', getAssessmentData(), {

            onSuccess : (res) => {

                router.navigateTo(`/assessments/quiz/question-manager/${res.data.assessmentId}`);

                disabled = false ;
            },
            onError : (response) => {

                disabled = false ;
            }
        } )
    }

    const updateAssessment = () => {

        disabled = true ;

        router.post(`/api/assessment/quiz/update/${assessmentId}`, getAssessmentData() , {
            onSuccess : (response) => {

                // router.navigateTo('/assessments');
            },
            onError : (response) => {
                disabled = false ;
            }
        } )
    }

    const getAssessmentData = () => {
       
        return {
            title : assessmentTitle,
            assessmentTypeId : assessmentType,
            duration,
            startDate,
            endDate,
            description : assessmentDescription,
            contributorType : selectedContributorsOption,
            quizTakerType : selectedQuizTakersOption,
            contributors : selectedContributors.flatMap( (contributor) => [ contributor.id ]),
            quizTakers,
            shouldDisplayResults,
            shouldGradeWithAssessmentTypeMaxScore,
            shouldShuffleQuestions,
        }
    }

    const addContributors = () => {
        
        if( selectedContributorsOption  === "selected_teachers" ){

            router.getWithToken('/api/teachers', {

                onSuccess: ( res ) => {
                    contributors = res.data
                }
            });

            slidePanelState = slidePanelStates.selected_teachers

            isSlidePanelOpen = true;
        }
    }

    const viewContributors = () => {

        slidePanelState = slidePanelStates.view_contributors;

        isSlidePanelOpen = true;

    }


    const addQuizTakers = async () => {
        
        await router.getWithToken('/api/classes', {
            onSuccess: ( res ) => {

                classQuizTakers = res.data;
                
            }
        });

        if( selectedQuizTakersOption  === "selected_classes" ){

            slidePanelState = slidePanelStates.selected_classes

            isSlidePanelOpen = true;
        }

        if( selectedQuizTakersOption  === "selected_students" ){

            classes = classQuizTakers.flatMap(( grade ) => [{ placeholder: grade.class_name, value: grade.id }] );

            slidePanelState = slidePanelStates.selected_students

            isSlidePanelOpen = true;
        }
    }


    const selectClassQuizTakers = ( quizTaker ) => {

         if( inArray(quizTaker.id, selectedClassQuizTakers, 'id') ){

            selectedClassQuizTakers = removeItem(quizTaker.id, selectedClassQuizTakers, 'id');

            return;
        }

        selectedClassQuizTakers = [ ...selectedClassQuizTakers, quizTaker ]

        quizTakers = selectedClassQuizTakers.flatMap( (grade) => [ grade.id ]);
    }

    const selectStudentQuizTakers = ( quizTaker ) => {

         if( inArray(quizTaker.studentId, selectedStudentQuizTakers, 'studentId') ){

            selectedStudentQuizTakers = removeItem(quizTaker.id, selectedStudentQuizTakers, 'studentId');

            return;
        }

        selectedStudentQuizTakers = [...selectedStudentQuizTakers, quizTaker]
        
        quizTakers = selectedStudentQuizTakers.flatMap( (student) => [ student.studentId ]);
    }

    const viewQuizTakers = () => {

        slidePanelState = slidePanelStates.view_quiz_takers;

        isSlidePanelOpen = true;

    }

    const selectContributors = (contributor) => {

        if( inArray( contributor.id, selectedContributors, 'id' ) ){

            selectedContributors = removeItem( contributor.id, selectedContributors, 'id' );

            return;
        }

        selectedContributors = [...selectedContributors, contributor]

    }

    const getStudents = (classId) => {

        router.getWithToken(`/api/students?classId=${classId}`, {

            onSuccess: ( res ) => {

                studentQuizTakers = res.data

            }
        });
    }

    $: showAddQuizTakersButton = ( (selectedQuizTakersOption  === "selected_classes") ||  (selectedQuizTakersOption  === "selected_students") );

    $: showAddContributorsButton = selectedContributorsOption  === "selected_teachers";

</script>


<Layout>

    <TopHeader title="Create Quiz"/>

    <SlidePanel title={ slidePanelState } showSheet={ isSlidePanelOpen } on:onpanelstatus={ (e) => isSlidePanelOpen = e.detail.status } >
        <AppContainer>
            <div class="border bg-white p-8 rounded-lg max-w-8xl">
                <div class="flex items-center justify-between my-2 border-b pb-8">
                    <div>
                        <div class="text-2xl font-semibold min-w-max text-gray-700">Quiz Details</div>
                        <div class="text-gray-400 text-sm">Enter quiz details below</div>
                    </div>
                    
                    <div class="ml-72 pt-4 max-w-3xl">
                        { #if assessmentId }
                            <Button { disabled } on:click={ updateAssessment } buttonText="Update" />
                        { :else }
                            <Button { disabled } on:click={ createAssessment } buttonText="Create" />
                        { /if }
                    </div>
                </div>
        
                <div class="mt-12 space-y-6 w-full">
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[18rem] text-gray-700">Enter Quiz Title</span>
                        <div class="w-full">
                            <Input value={ assessmentTitle } on:input={ (e) => assessmentTitle = e.detail.input }  />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Enter Quiz Type</div>
                        <div class="w-full">
                            <Select on:selected={ (e) => assessmentType = e.detail.value } on:deselected={ () => assessmentType = null } value={ assessmentType } options={ assessmentTypes } placeholder="Select an Assessment Type" className="text-sm py-2.5"  />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-3xl">
                        <div class="w-[18rem] flex-shrink-0 text-gray-700">
                            <p>Quiz Duration</p>
                            <small class="text-gray-400">Quiz Duration should be in minutes</small>
                        </div>
                        <div class="w-40">
                            <Input value={ duration }  on:input={ (e) => duration = e.detail.input } type="number" pattern="[0-9]+"  />
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-3xl">
                        <div class="w-[18rem] flex-shrink-0 text-gray-700">
                            <p>Enter Quiz Dates</p>
                            <small class="text-gray-400">Choose quiz start date and end date</small>
                        </div>
                        <div class="w-[17.5rem]">
                            { #key startDate }
                                <Datetimepicker value={ startDate } on:selected={ (e) => startDate = e.detail.datetime } placeholder="Enter Start Date"  />
                            { /key }
                            { #key endDate }
                                <Datetimepicker value={ endDate }  on:selected={ (e) => endDate = e.detail.datetime } placeholder="Enter End Date" />
                            { /key }
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl pt-4">
                        <label class="w-[18rem] flex-shrink-0 text-gray-700" for="">Enter Quiz Instructions</label>
                        <textarea on:input={ (e) => assessmentDescription = e.target.value } class="border w-full rounded-lg resize-none p-4 border-gray-300" cols="30" rows="5">{ assessmentDescription ?? '' }</textarea>
                    </div>
    
                    <div class="flex items-center justify-between my-2 border-b pt-16 pb-8">
                        <div>
                            <div class="text-2xl font-semibold min-w-max text-gray-700">Quiz Configuration</div>
                            <div class="text-gray-400 text-sm">Enter quiz details below</div>
                        </div>
                    </div>
    
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Who can contribute to this quiz?</div>
                        <div class="w-full flex items-center space-x-2">
                            <Select on:selected={ (e) => selectedContributorsOption = e.detail.value } value={ selectedContributorsOption  } options={ contributorsOptions } placeholder="Quiz Contributors" className="text-sm py-2.5"  />
                            { #if showAddContributorsButton }
                                <button on:click={ addContributors } class="min-w-max max-w-min border-2 p-2.5 rounded-lg text-gray-500">Add</button>
                                <button on:click={ viewContributors }  class="min-w-max max-w-min border-2 p-2.5 rounded-lg text-gray-500">View</button>
                            { /if }
                        </div>
                    </div>
    
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Who can take this quiz?</div>
                        <div class="w-full flex items-center space-x-2">
                            <Select on:selected={ (e) => selectedQuizTakersOption = e.detail.value }  value={ selectedQuizTakersOption } options={ quizTakersOptions } placeholder="Select Quiz Takers" className="text-sm py-2.5"  />
                            { #if showAddQuizTakersButton }
                                <button on:click={ addQuizTakers } class="min-w-max max-w-min border-2 p-2.5 rounded-lg text-gray-500">Add</button>
                                <button on:click={ viewQuizTakers } class="min-w-max max-w-min border-2 p-2.5 rounded-lg text-gray-500">View</button>
                            { /if }
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Display quiz results at the end of quiz</div>
                        <div class="w-full">
                            <input bind:checked={ shouldDisplayResults } type="checkbox">
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Use assessment type max score for grading</div>
                        <div class="w-full">
                            <input bind:checked={ shouldGradeWithAssessmentTypeMaxScore } type="checkbox">
                        </div>
                    </div>
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <div class="flex-shrink-0 w-[18rem] text-gray-700">Shuffle Questions</div>
                        <div class="w-full">
                            <input bind:checked={ shouldShuffleQuestions } type="checkbox">
                        </div>
                    </div>
                </div>
            </div>
        </AppContainer>


        <div slot="panel">

            { #if slidePanelState === slidePanelStates.selected_teachers  }
                { #each contributors as contributor, index( contributor.id ) }
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center space-x-4">
                            <input checked={ inArray(contributor.id, selectedContributors, 'id' ) } on:click={ () => selectContributors( contributor )  } type="checkbox" value={ contributor } id={ contributor.id }>
                            <label for={ contributor.id }>{ contributor.name }</label>
                        </div>
                    </div>
                { /each }
            { /if }

            { #if slidePanelState === slidePanelStates.view_contributors  }
                { #each selectedContributors as contributor, index( contributor.id ) }
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center space-x-4">
                            <p>{ contributor.name }</p>
                        </div>
                    </div>
                { /each }
            { /if }


            { #if slidePanelState === slidePanelStates.selected_classes  }
                { #each classQuizTakers as quizTaker, index( quizTaker.id ) }
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center space-x-4">
                            <input checked={ inArray(quizTaker.id, selectedClassQuizTakers, 'id' ) } on:click={ () => selectClassQuizTakers(quizTaker) } type="checkbox" value={ quizTaker } id={ quizTaker.id  }>
                            <label for={ quizTaker.id }>{ quizTaker.class_name }</label>
                        </div>
                    </div>
                { /each }
            { /if }

            { #if slidePanelState === slidePanelStates.selected_students  }

                <Select on:selected={ (e) => getStudents( e.detail.value ) } on:deselected={ () => studentQuizTakers = [] } options={ classes } placeholder="Select a Class" className="text-sm py-2.5"  />
                
                { #each studentQuizTakers as quizTaker, index( quizTaker.studentId ) }
                    <div class="flex flex-col space-y-2">
                        <div class="flex items-center space-x-4">
                            <input checked={ inArray(quizTaker.studentId, selectedStudentQuizTakers, 'studentId' ) } on:click={ () => selectStudentQuizTakers(quizTaker) } type="checkbox" value={ quizTaker } id={ quizTaker.studentId  }>
                            <label for={ quizTaker.studentId }>{ quizTaker.name }</label>
                        </div>
                    </div>
                { /each }

            { /if }

            { #if slidePanelState === slidePanelStates.view_quiz_takers  }
                
                { #if selectedQuizTakersOption === "selected_classes" }
                    { #each selectedClassQuizTakers as quizTaker, index( quizTaker.id ) }
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center space-x-4">
                                <p>{ quizTaker.class_name }</p>
                            </div>
                        </div>
                    { /each }
                { /if }

                { #if selectedQuizTakersOption === "selected_students" }
                    { #each selectedStudentQuizTakers as quizTaker, index( quizTaker.studentId ) }
                        <div class="flex flex-col space-y-2">
                            <div class="flex items-center space-x-4">
                                <p>{ quizTaker.name }</p>
                            </div>
                        </div>
                    { /each }
                { /if }

            { /if }

        </div>
    </SlidePanel>
    
</Layout>

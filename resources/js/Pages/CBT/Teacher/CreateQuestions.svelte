<script>
    import { onMount } from "svelte";
    import { router } from "../../../util";
    import { page } from "@inertiajs/svelte"
    import Button from "../../components/button.svelte";
    import Icons from "../../components/icons.svelte";
    import EditableQuestionCard from "../components/EditableQuestionCard.svelte";
    import Layout from "./components/layout.svelte";
    import QuestionsList from "./components/questions_list.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import CsvImportCard from "../components/CsvImportCard.svelte";
    import ImportMappingCard from "../components/ImportMappingCard.svelte";

    let question = {
        question : "",
        options : ["",""],
        correctAnswer : "",
        questionScore : "",
        source : ""
    };

    let importCard;

    let edit = false;

    let initQuestion = JSON.stringify(question);

    let classId = $page.props.classCode
    let assessmentId = $page.props.assessmentId
    let subjectId = $page.props.subjectId

    let questions = [];

    let showSlidePanel = false;

    let slidePanelState;

    let slidePanelStates = {
        uploadQuestions : "Upload File",
        importQuestions : "Import Questions",
    }
    
    let headings = {}

    let mappings = [
        { placeholder : "Question", value: "question", isSelected: false },
        { placeholder : "Option", value: "options", isSelected: false },
        { placeholder : "Score", value: "questionScore", isSelected: false },
        { placeholder : "Correct Answer", value: "correctAnswer", isSelected: false },
    ];

    let importKey;

    let resetMappings = JSON.stringify(mappings);

    let mappedFields = {}

    $: getAvailableMappings = () => {

        return mappings?.filter( (field) => field.isSelected == false );
    }


    onMount(() => {
        
        getQuestions();

    })


    const getQuestions = () => {

        router.get(`/api/get-questions?classId=${classId}&assessmentId=${assessmentId}&subjectId=${subjectId}`, {
            onSuccess: (res) => {
                questions = res.data
            }
        })
    }
    const createQuestion = (ques) => {
    
        question = JSON.parse(initQuestion);
        getQuestions();
    }

    const editQuestion = (ques) => {
        edit = true
        question = ques
    }

    const updateQuestion = () => {
        edit = false;
        question = JSON.parse(initQuestion);
        getQuestions();
    }

    const uploadQuestions = () => {

        let data = new FormData();

        data.append('file', importCard.uploadFile);
        data.append('assessmentId', assessmentId);

        
        router.postForm('/api/question/import', data , {

            onSuccess : (res) => {

                importKey = res.data.key;
                headings = res.data.headings;
                slidePanelState = slidePanelStates.importQuestions
            }
        })
    }

    const importQuestion = () => {
        
        router.post('/api/question/import' , { mappings: mappedFields, assessmentId, key: importKey, classId, subjectId }, {
            onSuccess : (res) => {
                getQuestions();
                closeSheet();
            }
        })
    }

    const closeSheet = () => {
        showSlidePanel = false
        reset();
    }

    const showSheet = (state) => {

        slidePanelState = state;
        showSlidePanel = true;

    }

    const reset = () => { 
        question = JSON.parse(initQuestion);
        mappings = JSON.parse(resetMappings);
        mappedFields = {}
    }


    const mapFields = (selected) => {

        let field = mappings.filter( (field) => (selected.value === field.value) && ( selected.value != "options" ) )[0];
        
        if( field ){
            field.isSelected = ! field.isSelected ;
        }

        if( (selected.selected) && ( selected.value != "options" ) ){
            mappedFields[selected.value] = Object.keys(headings)[selected.index]
        }
        
        if( (selected.selected) && ( selected.value == "options" ) ){
            mappedFields[selected.value] = mappedFields[selected.value] ? [ ...mappedFields[selected.value], Object.keys(headings)[selected.index] ] : [ Object.keys(headings)[selected.index] ];
        }

        if( (selected.deselected) && ( selected.value != "options" ) ){
            delete mappedFields[selected.value];
        }
        
        if( (selected.deselected) && ( selected.value == "options" ) ){
            mappedFields[selected.value] = mappedFields[selected.value]?.filter((mapped) => mapped != Object.keys(headings)[selected.index]);
        }

        mappings = mappings;
    }


</script>

<Layout >
    <div class="relative mt-20">
         <div class="fixed ml-56 h-16 z-30 inset-x-0 flex items-center justify-between border-b bg-white">
             <div class="flex space-x-3 items-center py-4 px-8">
                 <Icons icon="chart" className="h-5 w-5" />
                 <span class="mx-2 text-sm font-medium text-gray-700">Assessments</span>
                 <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                 <span class="text-sm font-medium text-gray-700">Questions</span>
             </div>
         </div>
 
         <div class="fixed ml-56 mt-16 z-30 inset-x-0 flex border-b items-center h-16 bg-white">
             <div class="px-8 w-[32rem] shrink-0 border-r h-full">
                   
             </div>
             <div class="px-8 py-4 min-w-[32rem] flex items-center justify-between w-full">
                 <h3 class="text-gray-800 text-sm font-bold min-w-max">Questions</h3>
                 <div class="flex items-center space-x-2">
                     <Button on:click={ () => showSheet(slidePanelStates.uploadQuestions) } buttonText="Import Questions" className="min-w-max text-sm bg-green-600 hover:bg-green-500 focus:bg-green-600 focus:ring-green-300" />
                 </div>
             </div>
         </div>
        
         <div class="fixed ml-56 mt-52 w-[32rem] inset-0 bg-white border-r min-h-screen overflow-y-auto">
            <div class="relative flex flex-col h-full">
                <div class="pb-52 max-w-lg px-6">
                    <EditableQuestionCard on:updated={ updateQuestion } { edit } { subjectId } { classId } on:saved={ (e) => createQuestion(e.detail.question) } correctAnswer={ question.correctAnswer } question={ question.question } options={ question.options } questionScore={ question.questionScore } questionId={ question.questionId } source={ question.source }/>
                </div>
            </div>
         </div>
         <div class="ml-[46rem] fixed mt-52 min-w-[32rem] shrink-0 inset-0 bg-white min-h-screen overflow-auto">
            <div class="relative flex flex-col h-full">
                <div class="absolute inset-0 bg-white">
                    <div class="container h-[30rem]">
                        <div class="flex items-center text-center rounded-lg h-full dark:border-gray-700">
                            <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
                                <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </div>
                                <h1 class="mt-3 text-lg text-gray-800 dark:text-white">No questions found</h1>
                                <p class="mt-2 text-gray-500 dark:text-gray-400">There aren't any available questions.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute z-50 bg-white w-full">
                    <QuestionsList { questions } on:edit={ (e) => editQuestion(e.detail) }  />
                </div>
            </div>
         </div>
    </div>
 </Layout>

 <SlidePanel title={ slidePanelState } showSheet={ showSlidePanel } on:close-button={ closeSheet } >

    { #if (slidePanelState === slidePanelStates.uploadQuestions) }

       <CsvImportCard bind:this={ importCard } on:on-upload={ uploadQuestions } />

    { /if }

    { #if (slidePanelState === slidePanelStates.importQuestions) }

       <ImportMappingCard on:deselected={ (e) => mapFields(e.detail) }  on:selected={ (e) => mapFields(e.detail) } { headings } options={ getAvailableMappings() } on:import={ importQuestion } on:back-button={ () => slidePanelState = slidePanelStates.uploadQuestions } />

    { /if }
</SlidePanel>
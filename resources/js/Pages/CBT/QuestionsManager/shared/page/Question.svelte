<script>
// @ts-nocheck

    import Button from "../../../../../components/button.svelte";
    import Icons from "../../../../../components/icons.svelte";
    import SlidePanel from "../../../../../components/slide_panel.svelte";
    import Layout from "../../../../../layouts/Layout.svelte";
    import EditableQuestionCard from "../../../../components/EditableQuestionCard.svelte";
   
    import CsvImportCard from "../../../../components/CsvImportCard.svelte";
    import ImportMappingCard from "../../../../components/ImportMappingCard.svelte";
    import { onMount } from "svelte";
    import { router } from "../../../../../../util";
    import { page, inertia } from "@inertiajs/svelte";
    import Select from "../../../../../components/select.svelte";
    import Modal from "../../../../../components/modal.svelte";
    import Input from "../../../../../components/input.svelte";
    import QuestionsList from "../components/questions_list.svelte";
    import QuestionsBank from "../components/questions_bank.svelte";
    import AssessmentQuestionBanks from "../components/assessment_question_banks.svelte";
    import Drawer from "../../../../../components/drawer.svelte";


    let question = {
        questionId: "",
        question : "<p></p>",
        options : ["<p></p>","<p></p>"],
        correctAnswer : "",
        questionScore : "1",
        sectionId : "",
        topicId : "",
        source : ""
    };

    let selectedSection;
    let selectedQuestionType;
    let selectedQuestionBankId;


    let questionType = AssessmentQuestionBanks;

    let importCard;

    let importErrorsLink = '';

    let edit = false;
    let shouldEditSection = false;
    let disabled = false;
    let questionEdit = false;
    let showModal = false;
    let showDrawer = false;
    let hasImportError = false;

    let initQuestion = JSON.stringify(question);

    let classId = $page.props.classCode
    let assessmentId = $page.props.assessmentId
    let subjectId = $page.props?.subjectId
    let subjectTitle = $page.props?.subjectTitle
    let classes = $page.props?.questionBankClasses
    let questionBankId = $page.props.questionBankId
    let isAssessmentQB = $page.props.isAssessmentQB;

    let questionBankQuestions = [];
    let questionBanks = [];
    let selectedQuestionBankQuestions = [];
    let questionBankSections = [];
    let selectedQuestionBankSections = [];
    let topics = [];
    let questionTypes = [];


    let checkedQuestionBankQuestions = []
    let checkedSelectedQuestionBankQuestions = []

    let actions = [
        { placeholder: 'Assign Questions To Assessment', value: 'assign'},
        { placeholder: 'Unassign Questions From Assessment', value: 'unassign'},
        { placeholder: 'Generate New Questions From Questions', value: 'generate'},
        { placeholder: 'Move Questions To A Section', value: 'moveQuestionToSection'},
    ]

    let showSlidePanel = false;

    let slidePanelState;

    let slidePanelStates = {
        addNewQuestion: "Add New Question",
        editQuestion : "Edit Question",
        uploadQuestions : "Upload File",
        importQuestions : "Import Questions",
        addSection : "Add Section",
        editSection : "Edit Section",
    }
    
    let currentQuestionBankSection = {};

    let headings = {}


    let mappings = [
        { placeholder : "Question", value: "question", isSelected: false },
        { placeholder : "Option", value: "options", isSelected: false },
        { placeholder : "Score", value: "questionScore", isSelected: false },
        { placeholder : "Correct Answer", value: "correctAnswer", isSelected: false },
    ];

    let sectionData = {
        sectionTitle : "",
        sectionDescription : "",
        sectionId : "",
        sectionScore: "",
        sectionTotalQuestions: "",
        questionType : ""
    }

    let initSectionData = JSON.stringify(sectionData);

    let importKey;

    let resetMappings = JSON.stringify(mappings);

    let mappedFields = {}

    $: getAvailableMappings = () => {

        return mappings?.filter( (field) => field.isSelected == false );
    }


    onMount(() => {
        
        // getQuestions();
        getAssessmentQuestionBanks();
        getQuestionBankSections();

        getQuestionBankQuestionsRequest();
        
        getQuestionTypes();
        
        // getQuestionTopics();

    })

    const getAssessmentQuestionBanks = () => {

        let url = `/api/assessment/question-banks/${assessmentId}?`;

        if( subjectId ) url += `&subject=${subjectId}`;
        if( classId ) url += `&class=${classId}`;

        router.getWithToken(url, {
            onSuccess : (res) => {
                questionBanks = res.data.flatMap((questionBank) => [{ placeholder: `${questionBank.subject}   |  ${questionBank.teacher}   |   ${questionBank.totalQuestions} Ques`, value: questionBank.questionBankId }])
            }
        })
    }

    const getSelectedQuestionBankSections = (selectedQuestionBankID) => {

        router.getWithToken(`/api/question-bank/sections/${selectedQuestionBankID}`, {
            onSuccess : (res) => {

                selectedQuestionBankSections = res.data.flatMap((section) => [{ placeholder: section.sectionTitle, value: section.sectionId, questionType: section.questionType, sectionDescription: section.sectionDescription, sectionTotalQuestions: section.sectionTotalQuestions, sectionScore: section.sectionScore, sectionTitle: section.sectionTitle, sectionId: section.sectionId }]);
            }
        })
    }

    const getQuestionBankSections = () => {

        router.getWithToken(`/api/question-bank/sections/${questionBankId}`, {
            onSuccess : (res) => {

                questionBankSections = res.data.flatMap((section) => [{ placeholder: section.sectionTitle, value: section.sectionId, questionType: section.questionType, sectionDescription: section.sectionDescription, sectionTotalQuestions: section.sectionTotalQuestions, sectionScore: section.sectionScore, sectionScore: section.sectionScore, sectionTitle: section.sectionTitle, sectionId: section.sectionId }]);
            }
        })
    }

    // const getQuestions = (selectedQuestionBankId) => {


    //     let url = `/api/questions?questionBankId=${selectedQuestionBankId}&assessmentId=${assessmentId}&perPage=20`;

    //     if( subjectId ) url += `&subjectId=${subjectId}`;
    //     if( classId ) url += `&classId=${classId}`;

    //     return router.getWithToken(url, {

    //         onSuccess : async (response) => {

    //             newQuestions = response.data
    //         },

    //         onError : (response) => {
    //             // console.log(response)
    //         }
    //     })
    // }

    const getQuestionBankQuestions = (selectedQuestionBankID) => {

        selectedQuestionBankId = selectedQuestionBankID;

        getSelectedQuestionBankSections(selectedQuestionBankId);
        getSelectedQuestionBankQuestionsRequest(selectedQuestionBankId);

    }
    
    const getQuestionTopics = () => {

        router.getWithToken(`/api/get-question-topics?questionBankId=${questionBankId}`, {
            onSuccess: (res) => {
                topics = res.data.flatMap((topic) => [{ placeholder: topic.topicTitle, value: topic.topicId }]);
            }
        })
    }

    const getSelectedQuestionBankQuestionsRequest = () => {

        
        router.getWithToken(`/api/get-questions/${selectedQuestionBankId}`, {
            onSuccess: (res) => {
                selectedQuestionBankQuestions = res.data
            }
        })
    }

    const getQuestionBankQuestionsRequest = () => {

        
        router.getWithToken(`/api/get-questions/${questionBankId}`, {
            onSuccess: (res) => {
                questionBankQuestions = res.data
            }
        })
    }

   
    const getQuestionTypes = () => {

        router.getWithToken('/api/question-types', {
            onSuccess : (response) => {
                questionTypes = response.data.flatMap((questionType) => [{ placeholder : questionType, value: questionType } ]);
            },
            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const createQuestion = (ques) => {
    
        disabled = false;

        questionEdit = ! questionEdit
        question = JSON.parse(initQuestion);

        question.sectionId = ques.sectionId;
        question.topicId = ques.topicId;

        getQuestions();
    }

    const editQuestion = (ques) => {

        let initEditQuestion = JSON.stringify(ques);

        edit = true;

        questionEdit = ! questionEdit;

        question = JSON.parse(initEditQuestion);

        showSheet( slidePanelStates.editQuestion );

    }

    const updateQuestion = () => {

        disabled = false;

        edit = false;

        questionEdit = ! questionEdit

        question = JSON.parse(initQuestion);
        
        getQuestionBankQuestionsRequest();

        closeSheet();

    }

    const saveQuestion = () => {

        getQuestionBankQuestionsRequest();
        closeSheet();

        disabled = false;
    }

    const uploadQuestions = () => {

        if( disabled ) return;

        disabled = true;

        let data = new FormData();

        data.append('file', importCard.uploadFile);
        data.append('assessmentId', assessmentId);

        
        router.postFormWithToken('/api/question/import', data , {

            onSuccess : (res) => {

                importKey = res.data.key;
                headings = res.data.headings;

                slidePanelState = slidePanelStates.importQuestions

                setTimeout(() => disabled = false, 2000 );
            }
        })
    }

    const importQuestion = () => {

        if( disabled ) return;

        disabled = true;
        
        router.postWithToken('/api/question/import' , { mappings: mappedFields, assessmentId, key: importKey, questionBankId, questionType: selectedQuestionType, sectionId: selectedSection }, {
            
            onSuccess : (res) => {

                getQuestionBankQuestionsRequest();
                selectedSection = null;
                closeSheet();



                setTimeout(() => disabled = false, 2000 );


                if( res.data.errors ) {
                    
                    sessionStorage.setItem('importError', res.data.errors)

                    hasImportError = true;

                    importErrorsLink = res.data.errors;

                }
            },
            onError : (res) => {

                getQuestionBankQuestionsRequest();
                // closeSheet();
                
                setTimeout(() => disabled = false, 2000 );
                
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
        sectionData = JSON.parse(initSectionData);

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

    const deleteQuestions = (questionIds) => {

        console.log( questionIds );

        router.postWithToken('/api/questions/delete', { questionIds, assessmentId }, {
            
            onSuccess: (res) => { 

                getQuestionBankQuestionsRequest();
            }
        })

    }

    const createSection = () => {
        
        disabled = true;

        router.postWithToken('/api/question-bank/create/section', { questionBankId, title: sectionData.sectionTitle, description: sectionData.sectionDescription, questionType: sectionData.questionType, sectionScore: sectionData.sectionScore, totalQuestions: sectionData.sectionTotalQuestions }, {
            onSuccess: (res) => {
                getQuestionBankSections();
                closeSheet();

                disabled = false;
            },
            onError: (res) => {
                disabled = false
            }
        });
    }

    const setSectionData = (value) => {

        currentQuestionBankSection = questionBankSections.filter((section) => section.value === value )[0];
        sectionData = currentQuestionBankSection;

        shouldEditSection = true;

    }

    const resetSectionData = () => {

        sectionData = JSON.parse(initSectionData);
        currentQuestionBankSection = {}
        shouldEditSection = false;
    }

    const editSection = () => {

        sectionData = currentQuestionBankSection
        showSheet(slidePanelStates.editSection);
    }

    const updateSection = () => {
        
        disabled = true;

        router.postWithToken(`/api/question-bank/update/section/${sectionData.sectionId}`, { sectionTitle: sectionData.sectionTitle, sectionDescription: sectionData.sectionDescription, questionType: sectionData.questionType, sectionScore: sectionData.sectionScore, totalQuestions: sectionData.sectionTotalQuestions }, {

            onSuccess : (res) => {
                getQuestionBankSections();
                closeSheet();

                disabled = false;
            },
            onError: (res) => {
                disabled = false
            }
        });
    }

    const deleteSection = () => {
        
        shouldEditSection = false;

        router.postWithToken(`/api/question-bank/delete/section/${currentQuestionBankSection.sectionId}`, { questionBankId }, {

            onSuccess : (res) => {

                getQuestionBankSections();
                getQuestionBankQuestionsRequest();
            }
        });
    }

    const onSelectQuestionFromQuestionBank = (question) => {
        
        if( inArray(question, checkedQuestionBankQuestions) ) return;

        checkedQuestionBankQuestions.push(question);
        checkedQuestionBankQuestions = checkedQuestionBankQuestions;
    }

    const onDeSelectQuestionFromQuestionBank = (question) => {
        
        checkedQuestionBankQuestions = checkedQuestionBankQuestions.filter((selQuestion) => question != selQuestion );
    }

    const onCheckAllQuestionsFromQuestionBank = (questions, checkAll) => {

        if( checkAll === true ){

            questions.forEach((question) => onDeSelectQuestionFromQuestionBank(question) );

        }else{

            questions.forEach((question) => onSelectQuestionFromQuestionBank(question) );
        }  

    }

    const inArray = (value, array) => {
        return  array.includes(value)
    }


</script>

<Layout >

    <SlidePanel title={ slidePanelState } showSheet={ showSlidePanel }  on:onpanelstatus={ closeSheet } >
        <div class="fixed flex items-center h-16 justify-between bg-white py-4 px-8 border-b w-[calc(100vw-15rem)] z-50">
            <div class="flex space-x-2 items-center text-sm font-bold">
                <span class="text-gray-700">Question Bank</span>
                <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                <span class="text-gray-700">Questions</span>
                { #if subjectTitle }
                    <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                    <span class="text-gray-700">{ subjectTitle }</span>
                { /if }
                { #if classes }
                    <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                    <span class="text-gray-700">{ classes }</span>
                { /if }
            </div>
        </div>

        <div class="relative overflow-x-auto">
            <div class="fixed ml-60 mt-16 z-30 inset-x-0 flex border-b items-center h-16 bg-white">
                { #if isAssessmentQB  }
                    <div class="px-8 w-[36rem] shrink-0 border-r h-full">
                       
                        <div class="flex items-center h-full w-full">
                            <button on:click={ () => questionType = AssessmentQuestionBanks } type="button" class={`text-sm py-2 px-8 ${ questionType != AssessmentQuestionBanks ? 'text-gray-400 bg-gray-100' : 'text-gray-600 border-2 border-gray-500' } rounded-s-lg transition min-w-max w-full font-semibold`}>Questions</button>
                            <button on:click={ () => questionType = QuestionsBank } type="button" class={`text-sm py-2 px-8 ${ questionType != QuestionsBank ? 'text-gray-400 bg-gray-100' : 'text-gray-600 border-2 border-gray-500' } rounded-e-lg transition min-w-max  w-full font-semibold`}>Questions Archive</button> 
                        </div>      
                    </div>    
                  
                    
                { :else }
                    <div class="flex items-center space-x-4 justify-between px-8 w-[36rem] shrink-0 border-r h-full">
                        <p class="text-xl font-extrabold min-w-max text-gray-800">Add New Question</p>
                    </div>
                { /if }
            </div>
            
            <svelte:component questions={ selectedQuestionBankQuestions } sections={ selectedQuestionBankSections } assessmentQuestionBanks={ questionBanks } on:edit={ (e) => editQuestion(e.detail) } this={ questionType }  on:delete-questions={ (e) => deleteQuestions(e.detail.selectedQuestions) } on:get-question-bank={ (e) => getQuestionBankQuestions(e.detail.value) }   />                        
           
            <div class="fixed ml-60 w-[36rem] inset-x-0 bottom-0 bg-white border-r h-[calc(100vh-12rem)] overflow-y-auto">
                <div class="relative flex flex-col h-full">
                    <div class="max-w-xl px-8 pt-8">

                        
                        <!-- <EditableQuestionCard 
                            { topics } 
                            { edit } 
                            { sections } 
                            { subjectId }
                            { disabled } 
                            { questionEdit } 
                            { questionBankId }
                            on:saving={ () => disabled = true } 
                            on:error={ () => disabled = false } 
                            on:updated={ updateQuestion } 
                            on:saved={ (e) => createQuestion(e.detail.question) } 
                            questionBank={ true }
                            create={ true }
                            correctAnswer={ question.correctAnswer } 
                            question={ question.question } 
                            options={ question.options } 
                            questionScore={ question.questionScore } 
                            selectedSection={ question.sectionId } 
                            selectedTopic={ question.topicId } 
                            questionId={ question.questionId } 
                            source={ question.source }
                        /> -->
                    </div>
                </div>
            </div>


           
            <div class="fixed right-0 z-30 h-16 mt-16 px-6 w-[calc(100vw-51rem)] space-x-10 flex items-center justify-between"> 
                <div class="flex items-center space-x-4 justify-between w-full h-full">
                    <div>
                        <p class="py-2 text-gray-800 font-bold text-base">Questions</p>
                    </div>
                   <div class="flex items-center border-l h-full pl-6 justify-end">
                        <div class="flex space-x-2">
                            <Button on:click={ () => showSheet(slidePanelStates.addNewQuestion) } buttonText="New Question" className="text-xs" />
                            <Button on:click={ () => showSheet(slidePanelStates.uploadQuestions) } buttonText="Import Questions" className="min-w-max text-xs bg-green-600 hover:bg-green-500 focus:bg-green-600 focus:ring-green-300" />
                        </div>
                   </div>
                </div>
            </div>

          
            <QuestionsList 
                { shouldEditSection } 
                sections={ questionBankSections } 
                questions={ questionBankQuestions }
                on:section-deselected={ resetSectionData } 
                on:edit-section={ () => editSection() } 
                on:section-seclected={ (e) => setSectionData(e.detail.section) } 
                on:add-section={ () => { reset() ; showSheet( slidePanelStates.addSection ) } }  
                on:edit={ (e) => editQuestion(e.detail) } 
                on:delete-section={ deleteSection }
                on:delete-questions={ (e) => deleteQuestions(e.detail.selectedQuestions) }
                on:select-question={ (e) => onSelectQuestionFromQuestionBank(e.detail.questionId) } 
                on:deselect-question={ (e) => onDeSelectQuestionFromQuestionBank(e.detail.questionId) } 
                on:check-all={ (e) => onCheckAllQuestionsFromQuestionBank(e.detail.questions, e.detail.checkedAll) }
                on:actions={ () => showDrawer = true }
            />
                   
        </div>

        <div slot="panel">

            { #if ( slidePanelState === slidePanelStates.addNewQuestion ) || ( slidePanelState === slidePanelStates.editQuestion ) }
        
                <EditableQuestionCard  
                    on:saving={ () => disabled = true } 
                    on:error={ () => disabled = false } 
                    { edit } 
                    { topics } 
                    { disabled }
                    { questionEdit } 
                    { subjectId }
                    { classId }
                    { questionBankId }
                    questionId={ question.questionId } 
                    assigned={ question.assigned ?? false }
                    sections={ questionBankSections}
                    question={ question.question } 
                    correctAnswer={ question.correctAnswer } 
                    options={ question.options } 
                    questionScore={ question.questionScore } 
                    questionType={ question.questionType } 
                    selectedSection={ question.sectionId } 
                    selectedTopic={ question.topicId }
                    source={ question.source }  
                    on:cancel={ closeSheet } 
                    
                    on:updated={ (e) => updateQuestion() } 
                    on:saved={ (e) => saveQuestion() }
                    className="w-[40rem]" 
                />
        
            { /if }

            { #if (slidePanelState === slidePanelStates.uploadQuestions) }
                <CsvImportCard bind:this={ importCard } on:on-upload={ uploadQuestions } { disabled } />
            { /if }
        
            { #if (slidePanelState === slidePanelStates.importQuestions) }
        
                <ImportMappingCard  
                    sections={ questionBankSections}
                    { disabled } 
                    { headings }
                    options={ getAvailableMappings() }  
                    on:deselected={ (e) => mapFields(e.detail) }  
                    on:selected={ (e) => mapFields(e.detail) } 
                    on:import={ importQuestion } 
                    on:back-button={ () => slidePanelState = slidePanelStates.uploadQuestions }
                    on:section={ (e) => { selectedSection = e.detail.value; selectedQuestionType = e.detail.questionType } }
                    on:de-section={ (e) =>{ selectedSection = null; selectedQuestionType = null } }
                />

            { /if }

             { #if ( slidePanelState ===  slidePanelStates.addSection )  ||  ( shouldEditSection && slidePanelState ===  slidePanelStates.editSection ) }
        
                <div class="flex flex-col space-y-6 py-3 w-[32rem]">
                    <div>
                        <Input on:input={ (e) => sectionData.sectionTitle = e.detail.input } value={ sectionData.sectionTitle } label="Enter Section Title" labelStyle="font-semibold" />
                    </div>
        
                    <div>
                        <Select value={ sectionData.questionType } on:selected={ (e) => sectionData.questionType = e.detail.value } on:deselected={ (e) => sectionData.questionType = "" } options={ questionTypes } className="text-sm" optionsStyling="text-sm" placeholder="Select Question Type" label="Select Question Type" labelStyle="font-semibold"  />
                    </div>
        
                    <div>
                        <Input on:input={ (e) => sectionData.sectionDescription = e.detail.input }  value={ sectionData.sectionDescription } label="Enter Section Description"  labelStyle="font-semibold" />
                    </div>
        
                    <div>
                        <Input type="number" on:input={ (e) => sectionData.sectionTotalQuestions = e.detail.input }  value={ sectionData.sectionTotalQuestions } label="Enter Total Questions"  labelStyle="font-semibold" />
                    </div>
        
                    <div>
                        <Input type="number" on:input={ (e) => sectionData.sectionScore = e.detail.input }  value={ sectionData.sectionScore } label="Enter Section Score"  labelStyle="font-semibold" />
                    </div>
        
                    <div class="w-20">
                        { #if slidePanelState === slidePanelStates.editSection }
                            <Button { disabled } on:click={ updateSection } buttonText="Update" className="min-w-max max-w-min"/>
                        { :else }
                            <Button { disabled } on:click={ createSection } buttonText="Add Section" className="min-w-max max-w-min"/>
                        { /if } 
                    
                    </div>
                </div>
        
            { /if }
        </div>
    </SlidePanel>

    
 </Layout>

<Drawer show={ showDrawer } title="What would you like to do?" on:status={ (status) => showDrawer = status }>
    <div slot="drawer" class="w-full flex justify-center">
        <div class="flex flex-col h-80 w-[20rem] space-y-16 mt-1">
            <div>
               <p class="font-medium  text-center text-lg text-gray-600">Select an action</p>
                <button type="button"></button>
                <Select options={ actions } placeholder="Choose An Action" className="py-2.5 text-sm" />
            </div>
            <div class="space-y-3">
                <Button buttonText="Proceed" className="text-base min-w-full w-full py-2.5" />
                <Button on:click={ () => showDrawer = false } buttonText="Cancel" className="text-base min-w-full w-full py-2.5 bg-white text-gray-800 border-2 border-gray-800 hover:bg-transparent focus:bg-transparent focus:ring-gray-200" />
            </div>
        </div>
    </div>
</Drawer>

<Modal show={ hasImportError }>
    <div class="flex flex-col justify-center items-center h-full p-6 space-y-5">

        <div class="">
            <svg class="h-28 w-28" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="782.04441" height="701.88002" viewBox="0 0 782.04441 701.88002" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M609.48783,100.59015l-25.44631,6.56209L270.53735,187.9987,245.091,194.56079A48.17927,48.17927,0,0,0,210.508,253.17865L320.849,681.05606a48.17924,48.17924,0,0,0,58.61776,34.58317l.06572-.01695,364.26536-93.93675.06572-.01695a48.17923,48.17923,0,0,0,34.58309-58.6178l-110.341-427.87741A48.17928,48.17928,0,0,0,609.48783,100.59015Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M612.94784,114.00532l-30.13945,7.77236L278.68955,200.20385l-30.139,7.77223a34.30949,34.30949,0,0,0-24.6275,41.74308l110.341,427.87741a34.30946,34.30946,0,0,0,41.7431,24.62736l.06572-.01695,364.26536-93.93674.06619-.01707a34.30935,34.30935,0,0,0,24.627-41.7429l-110.341-427.87741A34.30938,34.30938,0,0,0,612.94784,114.00532Z" transform="translate(-208.9778 -99.05999)" fill="#fff"/><path d="M590.19,252.56327,405.917,300.08359a8.01411,8.01411,0,0,1-4.00241-15.52046l184.273-47.52033A8.01412,8.01412,0,0,1,590.19,252.56327Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M628.955,270.49906,412.671,326.27437a8.01411,8.01411,0,1,1-4.00241-15.52046l216.284-55.77531a8.01411,8.01411,0,0,1,4.00242,15.52046Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M620.45825,369.93676l-184.273,47.52032a8.01411,8.01411,0,1,1-4.00242-15.52046l184.273-47.52032a8.01411,8.01411,0,1,1,4.00241,15.52046Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M659.22329,387.87255l-216.284,55.77531a8.01411,8.01411,0,1,1-4.00242-15.52046l216.284-55.77531a8.01411,8.01411,0,0,1,4.00242,15.52046Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M650.72653,487.31025l-184.273,47.52033a8.01412,8.01412,0,0,1-4.00242-15.52047l184.273-47.52032a8.01411,8.01411,0,0,1,4.00242,15.52046Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M689.49156,505.246l-216.284,55.77532a8.01412,8.01412,0,1,1-4.00241-15.52047l216.284-55.77531a8.01411,8.01411,0,0,1,4.00242,15.52046Z" transform="translate(-208.9778 -99.05999)" fill="#f2f2f2"/><path d="M374.45884,348.80871l-65.21246,16.817a3.847,3.847,0,0,1-4.68062-2.76146L289.5963,304.81607a3.847,3.847,0,0,1,2.76145-4.68061l65.21247-16.817a3.847,3.847,0,0,1,4.68061,2.76145l14.96947,58.04817A3.847,3.847,0,0,1,374.45884,348.80871Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M404.72712,466.1822l-65.21247,16.817a3.847,3.847,0,0,1-4.68062-2.76146l-14.96946-58.04816A3.847,3.847,0,0,1,322.626,417.509l65.21246-16.817a3.847,3.847,0,0,1,4.68062,2.76145l14.96946,58.04817A3.847,3.847,0,0,1,404.72712,466.1822Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M434.99539,583.55569l-65.21246,16.817a3.847,3.847,0,0,1-4.68062-2.76145l-14.96946-58.04817a3.847,3.847,0,0,1,2.76145-4.68062l65.21247-16.817a3.847,3.847,0,0,1,4.68061,2.76146l14.96947,58.04816A3.847,3.847,0,0,1,434.99539,583.55569Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M863.63647,209.0517H487.31811a48.17928,48.17928,0,0,0-48.125,48.12512V699.05261a48.17924,48.17924,0,0,0,48.125,48.12507H863.63647a48.17924,48.17924,0,0,0,48.125-48.12507V257.17682A48.17928,48.17928,0,0,0,863.63647,209.0517Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M863.637,222.90589H487.31811a34.30948,34.30948,0,0,0-34.271,34.27093V699.05261a34.30947,34.30947,0,0,0,34.271,34.27088H863.637a34.30936,34.30936,0,0,0,34.27051-34.27088V257.17682A34.30937,34.30937,0,0,0,863.637,222.90589Z" transform="translate(-208.9778 -99.05999)" fill="#fff"/><circle cx="694.19401" cy="614.02963" r="87.85039" fill="#6c63ff"/><path d="M945.18722,701.63087H914.63056V671.07421a11.45875,11.45875,0,0,0-22.9175,0v30.55666H861.1564a11.45875,11.45875,0,0,0,0,22.9175h30.55666V755.105a11.45875,11.45875,0,1,0,22.9175,0V724.54837h30.55666a11.45875,11.45875,0,0,0,0-22.9175Z" transform="translate(-208.9778 -99.05999)" fill="#fff"/><path d="M807.00068,465.71551H616.699a8.01412,8.01412,0,1,1,0-16.02823H807.00068a8.01412,8.01412,0,0,1,0,16.02823Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M840.05889,492.76314H616.699a8.01412,8.01412,0,1,1,0-16.02823H840.05889a8.01411,8.01411,0,1,1,0,16.02823Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M807.00068,586.929H616.699a8.01412,8.01412,0,1,1,0-16.02823H807.00068a8.01411,8.01411,0,0,1,0,16.02823Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M840.05889,613.97661H616.699a8.01412,8.01412,0,1,1,0-16.02823H840.05889a8.01412,8.01412,0,1,1,0,16.02823Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M574.07028,505.04162H506.72434a3.847,3.847,0,0,1-3.84278-3.84278V441.25158a3.847,3.847,0,0,1,3.84278-3.84278h67.34594a3.847,3.847,0,0,1,3.84278,3.84278v59.94726A3.847,3.847,0,0,1,574.07028,505.04162Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M574.07028,626.25509H506.72434a3.847,3.847,0,0,1-3.84278-3.84278V562.46505a3.847,3.847,0,0,1,3.84278-3.84278h67.34594a3.847,3.847,0,0,1,3.84278,3.84278v59.94726A3.847,3.847,0,0,1,574.07028,626.25509Z" transform="translate(-208.9778 -99.05999)" fill="#e6e6e6"/><path d="M807.21185,330.781H666.91017a8.01411,8.01411,0,0,1,0-16.02823H807.21185a8.01411,8.01411,0,0,1,0,16.02823Z" transform="translate(-208.9778 -99.05999)" fill="#ccc"/><path d="M840.27007,357.82862H666.91017a8.01411,8.01411,0,1,1,0-16.02822h173.3599a8.01411,8.01411,0,0,1,0,16.02822Z" transform="translate(-208.9778 -99.05999)" fill="#ccc"/><path d="M635.85911,390.6071H506.51316a3.847,3.847,0,0,1-3.84277-3.84277V285.81706a3.847,3.847,0,0,1,3.84277-3.84277H635.85911a3.847,3.847,0,0,1,3.84277,3.84277V386.76433A3.847,3.847,0,0,1,635.85911,390.6071Z" transform="translate(-208.9778 -99.05999)" fill="#6c63ff"/></svg>
        </div>
       <div class="flex flex-col items-center space-y-6">
            <p class="font-bold text-gray-800 text-lg">There were some Import Errors</p>

            <a class="text-blue-500 text-sm" href={ importErrorsLink }>Click to Download</a>
       </div>

       <div class="pt-3">
            <Button on:click={ () => { sessionStorage.removeItem('importError'); hasImportError = false; importErrorsLink = '' } } buttonText="Close" className="text-sm" />
       </div>
       
    </div>
</Modal>


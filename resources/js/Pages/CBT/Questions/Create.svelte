<script>
    import Button from "../../components/button.svelte";
    import Icons from "../../components/icons.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import EditableQuestionCard from "../components/EditableQuestionCard.svelte";
    import QuestionBank from "./question_bank.svelte";
    import AssessmentQuestions from "./assessment_questions.svelte";
    import AssignedQuestions from "./assigned_questions.svelte";
    import CsvImportCard from "../components/CsvImportCard.svelte";
    import ImportMappingCard from "../components/ImportMappingCard.svelte";
    import { onMount } from "svelte";
    import { router } from "../../../util";
    import { page, inertia } from "@inertiajs/svelte";
    import { Editor, Node, mergeAttributes } from "@tiptap/core";
    import Select from "../../components/select.svelte";
    import Modal from "../../components/modal.svelte";
    import Input from "../../components/input.svelte";
    import moment from "moment";

    
    
    
    let questionType = AssessmentQuestions;
    let importCard;
    let slidePanelState;
    let selectedSection;
    let selectedQuestionType;


    let showSlidePanel = false;
    let edit = false;
    let create = false;
    let disabled = false;
    let showModal = false;
    let exportQuestionsModal = false;
    let hasImportError = false;

    let questionEdit = false;
    let refreshQuestions = false;
    
    let questionCurrentPageNumber = 1;
    let questionLastPageNumber;

    let questionBankCurrentPageNumber = 1;
    let questionBankLastPageNumber;

    let assignedQuestionCurrentPageNumber = 1;
    let assignedQuestionLastPageNumber;

    let importErrorsLink = '';

    let sectionsFilter = [];
    let sections = [];
    let questionFormSections = []
    let assessmentSections = []
    let topics = [];

    let assignedQuestions =  [];

    let assessmentTypes = [];
    let questionTypes = [];
    let assessmentCategories = [];
    let subjects = [];
    let classes = [];
    let sessions = [];
    let terms = [];

    let questionsToBeAssigned = [];
    let newQuestions = [];
    let pushedQuestions = [];
    let selectedQuestions = [];

    let questionBank = [];
    let assessmentQuestionBanks = [];
    let newQuestionBank = [];
    let pushedQuestionBank = [];


    let assessmentId = $page.props.assessmentId;
    let assessmentTitle = $page.props.assessmentTitle;
    let subjectId = $page.props.subjectId ?? null;
    let classId = $page.props.classId ?? null;
    let subjectTitle = $page.props.subjectTitle;
    let questionBankId = $page.props.questionBankId;
    let questionBankClasses = $page.props.questionBankClasses;

    let selectedQuestionBankId;

    let question = {
        question : "<p></p>",
        options : ["<p></p>","<p></p>"],
        correctAnswer : "",
        questionScore : "1",
        questionType: "",
        sectionId : "",
        topicId : "",
        source : "",
        assigned : false,
    };

    let slidePanelStates = {
        openAddSection : "Add New Question",
        uploadQuestions : "Upload File",
        importQuestions : "Import Questions",
        edit : "Edit Question",
        addSection : "Add Section",
        editSection : "Edit Section",
    }
    
    let headings = {}
    let mappedFields = {}

    let sectionData = {
        sectionTitle : "",
        sectionDescription : "",
        sectionId : "",
        sectionScore: "",
        sectionTotalQuestions: "",
        questionType : ""
    }

    let initSectionData  = JSON.stringify(sectionData);

    let mappings = [
        { placeholder : "Question", value: "question", isSelected: false },
        { placeholder : "Option", value: "options", isSelected: false },
        { placeholder : "Score", value: "questionScore", isSelected: false },
        { placeholder : "Correct Answer", value: "correctAnswer", isSelected: false },
    ];

    let importKey;

    let initQuestion = JSON.stringify(question);
    let resetMappings = JSON.stringify(mappings);

   

    $: getAvailableMappings = () => {

        return mappings?.filter( (field) => field.isSelected == false );
    }

    onMount( async () => {

        getAssignedQuestions();
        getAssessmentQuestionBanks();
        getQuestionBank();


        getSubjects();
        getClasses();
        getAssessmentTypes();
        getTerms();
        getSessions();
        getAssessmentCategories();


        getAssessmentSections();

        getQuestionTypes();
        // getQuestionTopics();


        if( sessionStorage.getItem('importError') ){
            importErrorsLink = sessionStorage.getItem('importError');
            hasImportError = true;
        }
       
    });

    const setQuestionType = (type) => questionType = type;

    const getQuestionBank = () => {

        let url = `/api/question-bank?perPage=120&assessmentId=${assessmentId}`

        if( subjectId ) url += `&subjectId=${subjectId}`;
        if( classId ) url += `&classId=${classId}`;

        router.getWithToken(url, {
            
            onSuccess : (response) => {

                newQuestionBank = response.data
                questionBankLastPageNumber = response.meta.last_page;
            },
            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const getAssessmentQuestionBanks = () => {

        let url = `/api/assessment/question-banks/${assessmentId}?`;

        if( subjectId ) url += `&subject=${subjectId}`;
        if( classId ) url += `&class=${classId}`;

        router.getWithToken(url, {
            onSuccess : (res) => {
                assessmentQuestionBanks = res.data.flatMap((questionBank) => [{ placeholder: `${questionBank.subject}   |  ${questionBank.teacher}   |   ${questionBank.totalQuestions} Ques`, value: questionBank.questionBankId }])
            }
        })
    }

    const getAssignedQuestions = () => {

        let url = `/api/questions?assessmentId=${assessmentId}&perPage=20&assigned=1`;

        if( subjectId ) url += `&subjectId=${subjectId}`;
        if( classId ) url += `&classId=${classId}`;


        router.getWithToken(url, {
            
            onSuccess : (response) => {
                assignedQuestions =  response.data ;
            },
            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const getQuestions = (selectedQuestionBankId) => {


        let url = `/api/questions?questionBankId=${selectedQuestionBankId}&assessmentId=${assessmentId}&perPage=20`;

        if( subjectId ) url += `&subjectId=${subjectId}`;
        if( classId ) url += `&classId=${classId}`;

        return router.getWithToken(url, {

            onSuccess : async (response) => {

                newQuestions = response.data
            },

            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const getQuestionBankQuestions = (selectedQuestionBankID) => {

        selectedQuestionBankId = selectedQuestionBankID;

        getSections(selectedQuestionBankId);
        getQuestions(selectedQuestionBankId);

    }

    const getAssessmentTypes = () => {

        router.getWithToken('/api/assessment-types', {
            onSuccess : (response) => {
                assessmentTypes = response.data.flatMap((type) => [{ placeholder : type.type, value: type.id } ]);
            },
            onError : (response) => {
                // console.log(response)
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

    const getAssessmentCategories = () => {

        assessmentCategories = [
            { placeholder: 'Standalone', value: 1 },
            { placeholder: 'Termly', value: 0 }
        ];
    }

    const getTerms = () => {

        router.getWithToken('/api/terms', {

            onSuccess : ( res ) => {
                terms = res.data.flatMap( (term) => [ { placeholder: term.term , value: term.id } ]);
            }
        })
    }


    const getSubjects = async () => {

       await router.getWithToken('/api/subjects', {
            onSuccess : (response) => {
                subjects = response.data.flatMap( subject => [{ placeholder : subject.subjectName, value: subject.subjectId } ]);
                
            },
            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const getSessions = () => {

        router.getWithToken('/api/sessions', {
            onSuccess : (response) => {
                sessions = response.data.flatMap((session) => [{ placeholder : session.session, value: session.id } ]);
            },
            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const getClasses = () => {

        router.getWithToken('/api/classes', {
            onSuccess : (response) => {
                classes = response.data.flatMap((grade) => [{ placeholder : grade.class_name, value: grade.id } ]);
            },
            onError : (response) => {
                // console.log(response)
            }
        })
    }

    const closeSheet = () => {
        reset();
        showSlidePanel = false
    }

    const reset = () => { 

        question = JSON.parse(initQuestion);
        mappings = JSON.parse(resetMappings);
        edit = false
        create = false
        mappedFields = {}

    }

    const showSheet = (state) => {

        slidePanelState = state;
        showSlidePanel = true;

    }
    
    $: hasBeenAssigned = (questionId) =>  assignedQuestions.some( (question) => question.questionId == questionId ) ;

    const assignQuestion = (question) => {

        router.postWithToken('/api/question/assign/'+ assessmentId, { questionId : question.questionId, subjectId }, {

            onSuccess : (response) => {

                // reloadQuestions();                
                
                assignedQuestions.push(question);
                assignedQuestions = assignedQuestions;
                                
                pushedQuestions =  pushedQuestions.filter( (ques) => ques.questionId === question.questionId );
               
            },
            onError : (response) => {
                // console.log(response);
            }
        } )
    }

    const massAssignQuestions = (questions) => {

        disabled = true;

        questionsToBeAssigned = questions;

        router.postWithToken('/api/question/mass-assign/' + assessmentId, { questions: questionsToBeAssigned, sectionId: selectedSection, classId, subjectId }, {

                onSuccess : (res) => {

                    questionsToBeAssigned = [];

                    getAssignedQuestions();

                    if( selectedQuestionBankId ) getQuestions(selectedQuestionBankId);

                    showModal = false;
                    selectedSection = null
                    disabled = false;
                
                },
                onError : (res) => {

                    if( res.errors.sectionId ){
                        showModal = true;
                    }

                    disabled = false;
                }
            } )

    }

    const unAssignQuestion = (question) => {
        
        router.postWithToken('/api/question/unassign/'+ assessmentId, { questionId : question.questionId, subjectId, classId }, {

            onSuccess : (response) => {

                assignedQuestions =  assignedQuestions.filter( (ques) => ques.questionId != question.questionId );

                if( response.data.assessmentId === assessmentId ) addQuestion(question);

            },
            onError : (response) => {
                console.log(response);
            }
        } )
    }

    const massUnassignQuestions = (questions) => {

        disabled = true;

        router.postWithToken('/api/question/mass-unassign/'+ assessmentId, { questions, classId, subjectId }, {

                onSuccess : (res) => {

                    getAssignedQuestions();

                    if( selectedQuestionBankId ) getQuestions(selectedQuestionBankId);
                   
                    disabled = false
                
                },
                onError : (res) => {

                }
            } )

    }

    const onSelectQuestion = (question) => {
        
        if( inArray(question, selectedQuestions) ) return;

        selectedQuestions.push(question);
        selectedQuestions = selectedQuestions;
    }

    const onDeSelectQuestion = (question) => {
        
        selectedQuestions = selectedQuestions.filter((selQuestion) => question != selQuestion );
    }

    const onCheckAllQuestions = (questions, checkAll) => {

        if( checkAll === true ){

            questions.forEach((question) => onDeSelectQuestion(question) );

        }else{

            questions.forEach((question) => onSelectQuestion(question) );
        }
       

    }

    const downloadQuestionsExcel = () => {
        
        if( selectedQuestions.length === 0 ) return;

        if( ! exportQuestionsModal ) return exportQuestionsModal = true;

        router.downloadExcelWithToken('/api/questions/download-excel', { questions: selectedQuestions }, {

            onSuccess : (response) => {

                const dataURL = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = dataURL;
                link.setAttribute('download', 'questions_' + moment().format('Y_M_D_H_m_s') + '.xlsx');
                document.body.appendChild(link);
                link.click();

                exportQuestionsModal = false

            },
            onError : (response) => {

                console.log(response);
            }
        } )
    }

    const openEditQuestionForm = (ques) => {

        console.log(ques)
        let initEditQuestion = JSON.stringify(ques);

        edit = true

        questionEdit = ! questionEdit

        question = JSON.parse(initEditQuestion);

        if( ques.assigned ){
            questionFormSections = assessmentSections 
        }else{
            create = true;
            questionFormSections = sections
        }

        showSheet(slidePanelStates.edit);

    }

    const openAddSection = () => {
       
        edit = false;
        create = false;
        showSheet(slidePanelStates.addSection);
    }

    const openQuestionUploadForm = () => {

        showSheet(slidePanelStates.uploadQuestions);
    }

    const updateQuestion = (e) => {

        if(selectedQuestionBankId) getQuestions(selectedQuestionBankId);
        
        getAssignedQuestions();

        closeSheet();

        disabled = false;

    }

    const saveQuestion = (e) => {

        getQuestions();
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

                getQuestions();
                closeSheet();

                setTimeout(() => disabled = false, 2000 );


                if( res.data.errors ) {
                    
                    sessionStorage.setItem('importError', res.data.errors)

                    hasImportError = true;

                    importErrorsLink = res.data.errors;

                }
            },
            onError : (res) => {

                getQuestions();
                // closeSheet();
                
                setTimeout(() => disabled = false, 2000 );
                
            }
        })
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

    const loadMoreQuestions = () => {

        if(refreshQuestions) return;

        if(questionCurrentPageNumber === questionLastPageNumber ) return;

        questionCurrentPageNumber ++

        getQuestions();
    }

    const loadMoreQuestionBank = () => {

        if(questionBankCurrentPageNumber === questionBankLastPageNumber ) return;

        questionBank = [ ...newQuestionBank ];

        questionBankCurrentPageNumber ++
        
        getQuestionBank();
    }

    const reloadQuestions = () => {

        refreshQuestions = true;

        questionCurrentPageNumber = 1;
        
        // oldQuestions = [];
        newQuestions = [];

        getQuestions();
    }

    const arrayDiff = (array1, array2) => {

        return array1.filter((arr) => ! inArray(arr, array2) );
    }

    const addQuestion = (ques) => {

        newQuestions.push(ques);
        newQuestions = newQuestions;
        pushedQuestions.push(ques);

    }

    const getSections = (selectedQuestionBankId) => {
        router.getWithToken(`/api/question-bank/sections/${selectedQuestionBankId}`, {
            onSuccess : (res) => {
                sections = res.data.flatMap((section) => [{ placeholder: section.sectionTitle, value: section.sectionId, questionType: section.questionType }]);
                sectionsFilter = [...sections, { placeholder: 'No Section', value: 'No Section' } ];
            }
        })
    }

    const getAssessmentSections = () => {

        let url = `/api/question/assessment/section/get/${assessmentId}?`;

        if( subjectId ) url += `&subjectId=${subjectId}`;
        if( classId ) url += `&classId=${classId}`;

        router.getWithToken(url, {
            onSuccess : (res) => {

                assessmentSections = res.data.flatMap( (section) => [ { placeholder: section.sectionTitle, value: section.sectionId, questionType: section.questionType } ]);

            }
        })
    }
    
    const getQuestionTopics = () => {

        router.getWithToken(`/api/get-question-topics?questionBankId=${questionBankId}`, {
            onSuccess: (res) => {
                topics = res.data.flatMap((topic) => [{ placeholder: topic.topicTitle, value: topic.topicId }]);
            }
        })
    }

    const createSection = () => {
        
        disabled = true;

        router.postWithToken(`/api/question/assessment/section/create/${assessmentId}`, { subjectId, classId, title: sectionData.sectionTitle, description: sectionData.sectionDescription, questionType: sectionData.questionType, sectionScore: sectionData.sectionScore, totalQuestions: sectionData.sectionTotalQuestions }, {
            onSuccess: (res) => {
                getAssessmentSections();
                closeSheet();

                disabled = false;
            },
            onError: (res) => {
                disabled = false
            }
        });
    }

    const editSection = (section) => {

        sectionData = section;

    }

    const updateSection = () => {
        
        disabled = true;

        router.postWithToken(`/api/question-bank/update/section/${sectionData.sectionId}`, { sectionTitle: sectionData.sectionTitle, sectionDescription: sectionData.sectionDescription, questionType: sectionData.questionType }, {

            onSuccess : (res) => {
                getSections();
                closeSheet();

                disabled = false;
            },
            onError: (res) => {
                disabled = false
            }
        });
    }

    const deleteSection = (sectionId) => {
        
        router.postWithToken(`/api/question-bank/delete/section/${sectionId}`, { questionBankId }, {

            onSuccess : (res) => {
                getSections();
            }
        });
    }

    const inArray = (value, array) => {
          return  array.includes(value)
    }
</script>

<Layout >
   <div class="relative mt-20">
        <div class="fixed ml-56 h-16 z-30 inset-x-0 flex items-center justify-between border-b border-gray-100 bg-white">
            <div class="flex space-x-3 items-center py-4 px-8">
                <Icons icon="chart" className="h-5 w-5" />
                <a use:inertia href={ `/assessments` }  class="mx-2 text-sm font-medium text-gray-700 uppercase">Assessments</a>
                <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                <a use:inertia href={ `/assessments/termly/manage/${assessmentId}` } class="mx-2 text-sm font-medium text-gray-700 uppercase">{ assessmentTitle }</a>
                <Icons icon="chevron_right" className="h-4 w-4 fill-gray-700" />
                <span class="text-sm font-medium text-gray-700 uppercase">{ subjectTitle } ( { questionBankClasses } )</span>
            </div>
        </div>

        <div class="fixed ml-56 mt-16 z-30 inset-x-0 flex border-b border-gray-100 items-center h-16 bg-white">
            <div class="px-8 w-[36rem] shrink-0 border-r border-gray-100 h-full">
                <div class="flex items-center justify-center h-full">
                    <button on:click={ () => setQuestionType(AssessmentQuestions) } type="button" class={`text-sm font-semibold py-2.5 px-8 ${questionType != AssessmentQuestions ? 'text-gray-400 bg-gray-100' : 'text-gray-600 border-2 border-gray-500' } rounded-s-lg transition w-full`}>Questions</button>
                    <button on:click={ () => setQuestionType(QuestionBank) } type="button" class={`text-sm font-semibold py-2.5 px-8 ${questionType != QuestionBank ? 'text-gray-400 bg-gray-100' : 'text-gray-600 border-2 border-gray-500' } rounded-e-lg transition w-full`}>Question Archive</button> 
                </div>      
            </div>
            <div class="px-8 py-4 min-w-[36rem] flex items-center justify-between w-full">
                <h3 class="text-gray-800 text-lg font-bold min-w-max">Assigned Questions</h3>
                <div class="flex items-center space-x-2">
                    <Button on:click={ openAddSection } buttonText="Add Section" className="min-w-max text-sm bg-green-600 hover:bg-green-500 focus:bg-green-600 focus:ring-green-300 py-3" />
                    <!-- <Button on:click={ openAddSection } buttonText="New Question" className="min-w-max text-sm py-3" /> -->
                </div>
            </div>
        </div>
       
        <div class="fixed ml-56 w-[36rem] inset-x-0 bg-white border-r border-gray-100 bottom-0 h-[calc(100vh-13rem)] overflow-y-auto">
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
                    <svelte:component on:mass-assign={ (e) => massAssignQuestions(e.detail.selectedQuestions) } on:load-more-question-bank={ loadMoreQuestionBank } on:load-more-questions={ loadMoreQuestions } on:edit={ (e) => openEditQuestionForm(e.detail) } on:assign={ (e) => assignQuestion(e.detail) } on:get-question-bank={ (e) => getQuestionBankQuestions(e.detail.value) } on:select-question={ (e) => onSelectQuestion(e.detail.questionId) } on:deselect-question={ (e) => onDeSelectQuestion(e.detail.questionId) } on:check-all={ (e) => onCheckAllQuestions(e.detail.questions, e.detail.checkedAll) } this={ questionType } questions={ newQuestions } questionBank={ newQuestionBank } { questionCurrentPageNumber} { questionLastPageNumber } { classes } { assessmentCategories } { sessions } { terms } { assessmentTypes } { subjects } sections={ sectionsFilter } { assessmentQuestionBanks }  />
                </div>
            </div>
        </div>
        <div class="fixed bottom-0 h-[calc(100vh-13rem)] ml-[35rem] w-full bg-white overflow-auto">
            <div class="relative flex flex-col h-full">
                <div class="pb-52 max-w-lg">
                    <AssignedQuestions on:mass-unassign={ (e) => massUnassignQuestions(e.detail.selectedQuestions) } on:edit={ (e) => openEditQuestionForm(e.detail) } on:unassign={ (e) => unAssignQuestion(e.detail) } { assignedQuestions } sections={ assessmentSections } on:download-excel={ downloadQuestionsExcel } on:select-question={ (e) => onSelectQuestion(e.detail.questionId) } on:deselect-question={ (e) => onDeSelectQuestion(e.detail.questionId) } on:check-all={ (e) => onCheckAllQuestions(e.detail.questions, e.detail.checkedAll) } />   
                </div>
            </div>
        </div>
   </div>
</Layout>

<SlidePanel title={ slidePanelState } showSheet={ showSlidePanel } on:close-button={ closeSheet } >
    { #if (slidePanelState === slidePanelStates.openAddSection) || (slidePanelState === slidePanelStates.edit) }
        
        <EditableQuestionCard  
            on:saving={ () => disabled = true } 
            on:error={ () => disabled = false } 
            questionId={ question.questionId } 
            { edit } 
            { create }
            { topics } 
            { disabled }
            { questionEdit } 
            { subjectId }
            { classId }
            assigned={ question.assigned }
            sections={ questionFormSections }
            questionBankId={ question.questionBankId }
            question={ question.question } 
            correctAnswer={ question.correctAnswer } 
            options={ question.options } 
            questionScore={ question.questionScore } 
            questionType={ question.questionType } 
            selectedSection={ question.sectionId } 
            selectedTopic={ question.topicId }
            source={ question.source }  
            on:cancel={ closeSheet } 
            on:updated={ (e) => updateQuestion(e) } 
            on:saved={ (e) => saveQuestion(e) } 
        />

    { /if }

    { #if (slidePanelState === slidePanelStates.uploadQuestions) }

       <CsvImportCard { disabled } bind:this={ importCard } on:on-upload={ uploadQuestions } />

    { /if }

    { #if (slidePanelState === slidePanelStates.importQuestions) }

       <ImportMappingCard  
            { sections } 
            { disabled } 
            { headings }
            options={ getAvailableMappings() }  
            on:deselected={ (e) => mapFields(e.detail) }  
            on:selected={ (e) => mapFields(e.detail) } 
            on:import={ importQuestion } 
            on:back-button={ () => slidePanelState = slidePanelStates.uploadQuestions } 
            on:question-type={ (e) => selectedQuestionType = e.detail.value }
            on:de-question-type={ (e) => selectedQuestionType = null }
            on:section={ (e) => selectedSection = e.detail.value }
            on:de-section={ (e) => selectedSection = null }
        />

    { /if }

    { #if (slidePanelState === slidePanelStates.addSection) }

        <div class="flex flex-col space-y-6 p-3">
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
                { #if slidePanelState == slidePanelState.editSection }
                    <Button { disabled } on:click={ updateSection } buttonText="Update" className="min-w-max max-w-min"/>
                { :else }
                    <Button { disabled } on:click={ createSection } buttonText="Add Section" className="min-w-max max-w-min"/>
                {/if}
            
            </div>
        </div>

    { /if }

</SlidePanel>

<Modal show={ showModal }>
    <div class="flex flex-col space-y-8 justify-center items-center h-full">

        <p class="font-bold text-gray-800 text-base">Choose Section</p>

        <Select on:selected={ (e) => selectedSection = e.detail.value } on:deselected={ () => selectedSection = null } options={ assessmentSections }  placeholder="Select Section" className="text-sm"/>

        <div class="flex items-center space-x-3 w-full">
            <button on:click={ () => { questionsToBeAssigned = []; showModal = false } } class="bg-gray-400 text-white hover:bg-gray-500 rounded-lg px-4 py-2.5 transition text-sm">Cancel</button>
            <Button { disabled } on:click={ () => massAssignQuestions(questionsToBeAssigned) } buttonText="Assign" className="text-sm"/>
        </div>
       
    </div>
</Modal>

<Modal show={ exportQuestionsModal }>
    <div class="flex flex-col space-y-8 justify-center items-center h-full">

        <p class="font-bold text-gray-800 text-lg">Export Questions</p>

        <p class="text-sm font-semibold">Total Questions: { selectedQuestions.length }</p>

        <div class="flex items-center space-x-3 w-full">
            <button on:click={ () => exportQuestionsModal = false } class="bg-gray-400 text-white hover:bg-gray-500 rounded-lg px-4 py-2.5 transition text-sm">Cancel</button>
            <Button { disabled } on:click={ downloadQuestionsExcel } buttonText="Export" className="text-sm"/>
        </div>
       
    </div>
</Modal>


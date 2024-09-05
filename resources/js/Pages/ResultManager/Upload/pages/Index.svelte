<script>
    import TopHeader from "../../../layouts/top_header.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import AppContainer from "../../../layouts/app_container.svelte";
    import Select from "../../../components/select.svelte";
    import Button from "../../../components/button.svelte";
    import Table from "../../../components/table.svelte";
    import Input from "../../../components/input.svelte";


    let assessmentTypes = [
        { placeholder: 'CAT 1', value: 'CAT 1'}
    ];

    let subjects = [
        { placeholder: 'English', value: 'English'}
    ];

    let classes = [
        { placeholder: 'Primary 1', value: 'Primary 1'}
    ];

    let terms = [
        { placeholder: 'First Term', value: 'First Term'},
        { placeholder: 'Second Term', value: 'Second Term'},
        { placeholder: 'Third Term', value: 'Third Term'},
    ];

    let academicSession = [
        { placeholder: '2023/2024', value: '2023/2024'}
    ];

    let shouldShowImportSheet = false
    let showResults = false;

    let selectedAssessmentType;
    let selectedclass;
    let selectedSubject;
    let selectedTerm;
    let selectedAcademicSession;

    const showImportSheet = () => shouldShowImportSheet = true

    let studentsResults = [
        { id: 1, studentName: 'Michah Richards', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 2, studentName: 'Lesli James', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 3, studentName: 'Nina Brown', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 4, studentName: 'Peter Michael', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 5, studentName: 'Jonh Jiin', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 6, studentName: 'Stewart Lore', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 7, studentName: 'Janet Lee', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
        { id: 8, studentName: 'Sonny House', subject: 'English', class: 'Primary 1', assessment: 'CAT 1', score: ""   },
    ]


    let resultsHeadings = ['S/N', 'Student Name', 'Subject', 'Class', 'Assessment', 'Score']
</script>

<Layout>
    <TopHeader title="Upload Results" />

    <AppContainer>

        <div class="shadow bg-white px-8 py-12 rounded-lg w-full">
            <div class="mx-auto max-w-4xl">
                <div class="flex items-center justify-between my-2 border-b border-gray-50 pb-8">
                    <div class="space-y-2">
                        <div class="text-xl font-medium min-w-max text-gray-700">
                            Assessment Details
                        </div>
                        <div class="text-gray-500 text-sm">
                            Fill in the assessment details below
                        </div>
                    </div>
                </div>
        
                <div class="my-12 space-y-6 w-full">
                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[18rem] text-gray-800 font-semibold">Select an Academic Session</span>
                        <div class="w-full">
                            <Select on:selected={ (e) => selectedAcademicSession = e.detail.value } options={ academicSession } optionsStyling="text-sm text-gray-800" placeholder="Select Academic Session" className="w-full text-sm text-gray-400" />
                        </div>
                    </div>

                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[18rem] text-gray-800 font-semibold">Select a Term</span>
                        <div class="w-full">
                            <Select on:selected={ (e) => selectedTerm = e.detail.value } options={ terms } optionsStyling="text-sm text-gray-800" placeholder="Select Term" className="w-full text-sm text-gray-400" />
                        </div>
                    </div>

                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[18rem] text-gray-800 font-semibold">Select an Assessment Type</span>
                        <div class="w-full">
                            <Select on:selected={ (e) => selectedAssessmentType = e.detail.value } options={ assessmentTypes } optionsStyling="text-sm text-gray-800" placeholder="Select Assessment Type" className="w-full text-sm text-gray-400" />
                        </div>
                    </div>

                    <div class="flex w-full items-center text-sm max-w-4xl">
                        <span class="flex-shrink-0 w-[18rem] text-gray-800 font-semibold">Select a Class</span>
                        <div class="w-full">
                            <Select on:selected={ (e) => selectedclass = e.detail.value } options={ classes } optionsStyling="text-sm text-gray-800" placeholder="Select Class" className="w-full text-sm text-gray-400" />
                        </div>
                    </div>
                    
                    <div class="flex pt-6 items-center w-full justify-end">
                        <Button on:click={ () => showResults = selectedAcademicSession && selectedAssessmentType && selectedSubject && selectedTerm } buttonText="Continue" className="text-base" />
                    </div>
                </div>
            </div>
            
        </div>
    </AppContainer>
</Layout>
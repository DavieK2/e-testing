<script>
    import Select from "../../../../../components/select.svelte";
    import Icons from "../../../../../components/icons.svelte";
    import Layout from "../../../../../layouts/Layout.svelte";
    import Button from "../../../../../components/button.svelte";
    import Table from "../../../../../components/table.svelte";
    import SlidePanel from "../../../../../components/slide_panel.svelte";
    import Input from "../../../../../components/input.svelte";
    import { router } from "../../../../../../util";
    import { page } from "@inertiajs/svelte";
    import { onMount } from "svelte";


    let showAddSectionForm = false

    let sections = [];

    let questionTypes = [];

    let slideFormState;
    
    let disabled = false;

    const panelState = {
        createSection : "Add New Section",
        edit : "Edit Section",
    }
    
    let slidePanelTitle;

    let sectionData = {
        sectionTitle : "",
        sectionDescription : "",
        sectionId : "",
        sectionScore: "",
        sectionTotalQuestions: "",
        questionType : ""
    }

    let initSectionData  = JSON.stringify(sectionData);


    let headings = ['SN', 'Title', 'Description','Total Questions', 'Section Score', 'Action']

    let questionBankId = $page.props.questionBankId;
    let assessmentTitle = $page.props.assessmentTitle;


    onMount(() => {

        getSections();
        getQuestionTypes();
        
    });

    const getQuestionTypes = () => {

        router.getWithToken('/api/question-types', {
            onSuccess : (res) => {

                questionTypes = res.data.flatMap( (questionType) => [{ placeholder: questionType.toUpperCase(), value: questionType }]);
            }
        })
    }

    const getSections = () => {

        router.getWithToken(`/api/question-bank/sections/${questionBankId}`, {
            onSuccess : (res) => {
                sections = res.data;
            }
        })
    }

    const addSectionsToQuestionBank = () => {
        
        return router.navigateTo(`/assessment/questions/question-bank/${questionBankId }`);

    }

    const createSection = () => {
        
        disabled = true;

        router.postWithToken('/api/question-bank/create/section', { questionBankId, title: sectionData.sectionTitle, description: sectionData.sectionDescription, questionType: sectionData.questionType, sectionScore: sectionData.sectionScore, totalQuestions: sectionData.sectionTotalQuestions }, {
            onSuccess: (res) => {
                getSections();
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
        openSectionForm(panelState.edit);
    }

    const updateSection = () => {
        
        disabled = true;

        router.postWithToken(`/api/question-bank/update/section/${sectionData.sectionId}`, { sectionTitle: sectionData.sectionTitle, sectionDescription: sectionData.sectionDescription, questionType: sectionData.questionType, sectionScore: sectionData.sectionScore, totalQuestions: sectionData.sectionTotalQuestions }, {

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

    const closeSheet = () => {

        sectionData = JSON.parse(initSectionData);
        showAddSectionForm = false

    };

    const openSectionForm = (state) => {
        slideFormState = state;
        slidePanelTitle = state;
        showAddSectionForm = true;
    }
    
</script>

<Layout>

    <SlidePanel title={ slidePanelTitle } showSheet={ showAddSectionForm } on:onpanelstatus={ closeSheet }>
  
        <div class="fixed flex items-center h-16 justify-between bg-white py-4 container border-b w-[calc(100vw-15rem)] z-50">
            <div class="flex space-x-2 items-center text-sm font-bold">
                <span class="text-gray-700">Question Bank</span>
                <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
                <span class="text-gray-700">{ assessmentTitle }</span>
                <Icons icon="chevron_right" className="h-4 w-4 fill-gray-800" />
                <span class=" text-gray-700">Sections</span>
            </div>
        </div>

        <div class="fixed container py-8 h-[calc(100vh-8rem)] w-[calc(100vw-15rem)] bottom-0 overflow-y-auto">
            <div class="container my-8">
                <div class="border bg-white p-8 rounded-lg max-w-8xl">
                    <div class="flex items-center justify-between my-2 border-b pb-8">
                        <div>
                            <div class="text-2xl font-extrabold min-w-max text-gray-700">Add Sections</div>
                            <div class="text-gray-400 text-sm mt-3">Please add relevant sections below</div>
                        </div>
                        <Button on:click={ () => openSectionForm(panelState.createSection) } buttonText="Add New Section" className="max-w-min min-w-max text-sm font-medium bg-white text-gray-800 hover:bg-gray-50 border-2 border-gray-800 focus:bg-transparent focus:ring-transparent" />
                    </div>
            
                    <div class="mt-12 space-y-6 w-full">
                    <Table { headings }>
                        { #each sections as section, index }
                            <tr>
                                <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">{ index + 1 }</td>
                                <th scope="row" class="py-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">{ section.sectionTitle }</th>
                                <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300">{ section.sectionDescription }</td>
                                <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300">{ section.sectionTotalQuestions ?? 0 }</td>
                                <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300">{ section.sectionScore ?? 0 }</td>
                                <td class="px-4 py-4 flex space-x-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                    <Button on:click={ () => editSection(section) } buttonText="Edit" className="text-xs bg-white text-blue-500 hover:bg-transparent border-2 border-blue-500 focus:bg-transparent focus:ring-transparent" />
                                    <Button on:click={ () => deleteSection(section.sectionId) } buttonText="Delete" className="text-xs bg-red-500 focus:ring-red-200 hover:bg-red-600 focus:bg-red-500" />
                                </td>
                            </tr>
                        { /each }
                    </Table>
                    </div>

                    <div class="flex w-full mt-10 justify-end">
                        <Button on:click={ addSectionsToQuestionBank } buttonText="Continue"  className="text-sm font-medium px-10"/>
                    </div>
                </div>
            </div>
        </div>

        <div slot="panel">
            <div class="flex flex-col space-y-6">
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
                    { #if slideFormState == panelState.edit }
                        <Button { disabled } on:click={ updateSection } buttonText="Update" className="min-w-max max-w-min font-medium"/>
                    { :else }
                        <Button { disabled } on:click={ createSection } buttonText="Add Section" className="min-w-max max-w-min font-medium"/>
                    {/if}
                   
                </div>
            </div>
        </div>
    </SlidePanel>

</Layout>
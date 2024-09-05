<script>
    import TopHeader from "../../../layouts/top_header.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import AppContainer from "../../../layouts/app_container.svelte";
    import Select from "../../../components/select.svelte";
    import Button from "../../../components/button.svelte";
    import DataTable from "../../../components/data_table.svelte";
    import SlidePanel from "../../../components/slide_panel.svelte";
    import Input from "../../../components/input.svelte";
    import { page } from '@inertiajs/svelte';
    import Dropdown from "../../../components/dropdown.svelte";
    import Drawer from "../../../components/drawer.svelte";


    let headings = ['S/N', 'Term', 'Actions']
    let terms = [
        { placeholder: 'First Term', value: 'First Term' },
        { placeholder: 'Second Term', value: 'Second Term' },
    ];

    let assessmentTypes = ['Test', 'Test', 'Test'];
    let showDrawer = false;

    let sessionTitle = $page.props.sessionTitle;
    let sessionId = $page.props.sessionId;

    let shouldShowResultTemplateForm = false;
    let disabled = false;

    let resultTemplates = []


    const createTemplate = () => {

    }

    const editTemplate = (id) => {

    }

    const updateTemplate = (id) => {

    }

    const deleteTemplate = (id) => {

    }

    const showResultTemplateForm = () => shouldShowResultTemplateForm = true;

    const closeResultTemplateForm = () => {

    }

    const reset = () => {

    }


    
</script>

<Layout>
    <SlidePanel showSheet={ shouldShowResultTemplateForm } title="Create New Result Template" on:onpanelstatus={ (e) => shouldShowResultTemplateForm = e.detail.status }>
        <TopHeader title={ `${sessionTitle} Academic Session` } ></TopHeader>

        <AppContainer>
        
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="flex flex-col w-full justify-center h-40 border rounded-lg bg-white px-8 space-y-2 hover:scale-105 transition">
                    <span class=" text-gray-600 text-sm">Total Students</span>
                    <span class="text-3xl text-gray-800 font-semibold">1,000</span>
                </div>
                <div class="flex flex-col w-full justify-center h-40 border rounded-lg bg-white px-8 space-y-2 hover:scale-105 transition">
                    <span class=" text-gray-600 text-sm">Total Classes</span>
                    <span class="text-3xl text-gray-800 font-semibold">0</span>
                </div>
                <div class="flex flex-col w-full justify-center h-40 border rounded-lg bg-white px-8 space-y-2 hover:scale-105 transition">
                    <span class=" text-gray-600 text-sm">Total Subjects</span>
                    <span class="text-3xl text-gray-800 font-semibold">0</span>
                </div>
                <div class="flex flex-col w-full justify-center h-40 border rounded-lg bg-white px-8 space-y-2 hover:scale-105 transition">
                    <span class=" text-gray-600 text-sm">Total Assessments</span>
                    <span class="text-3xl  text-gray-800 font-semibold">0</span>
                </div>
            </div>

            <DataTable { headings } >
                { #each terms as term,index(term.value) }
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 text-gray-800 whitespace-nowrap dark:text-white">
                            { index + 1 }
                        </th>
                        <td class="px-4 py-4 text-gray-800 dark:text-white">{ term.placeholder }</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                            <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border border-gray-300 text-gray-600">
                                <div class="flex flex-col">
                                    <button on:click={ () => showDrawer = true } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Assign Result Template</button>
                                </div>
                            </Dropdown>
                        </td>
                    </tr>
                { /each }
            </DataTable>
        
        </AppContainer>

        <div slot="panel">
            <div class="flex flex-col space-y-6 w-full py-8">
                <!-- <div>
                    <Input className="w-full" id="title" value={ resultTemplate.title } on:input={ (e) => resultTemplate.title = e.detail.input } label="Enter Template Title" placeholder="" />
                </div>

                <div>
                    <label for="" class="font-medium text-gray-700">Select Assessment Types</label>
                    <div class="pt-3">
                        { #each assessmentTypes as  type }
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="" id="">
                                <span>{ type}</span>
                            </div>
                        { /each }
                    </div>
                </div>
                <div class="flex">
                    <label for="" class="font-bold text-gray-700">Total Score: 50 </label>
                </div>
                <div class="mt-2">
                    <Input className="w-20" id="title" type="number" value={ resultTemplate.calculateTotalScoreTo } on:input={ (e) => resultTemplate.calculateTotalScoreTo = e.detail.input } label="Calculate Total Score To" />
                </div>
                <div class="">
                    { #if resultTemplate.id }
                        <Button { disabled } on:click={ updateTemplate } buttonText="Update Template" className="text-sm"/>
                    { :else }
                        <Button { disabled } on:click={ createTemplate } buttonText="Save Template" className="text-sm"/>
                    {/if}
                </div> -->
            </div>
        </div>
    </SlidePanel>
</Layout>

<Drawer show={ showDrawer } title="Assign Result Template" on:status={ (status) => showDrawer = status }>
    <div slot="drawer" class="w-full flex justify-center">
        <div class="flex flex-col h-80 w-[20rem] space-y-16 mt-1">
            <div>
               <p class="font-medium  text-center text-lg text-gray-600">Select a template</p>
                <button type="button"></button>
                <Select options={ resultTemplates } placeholder="Select Result Template" className="py-2.5 text-sm" />
            </div>
            <div class="space-y-3">
                <Button buttonText="Assign" className="text-base min-w-full w-full py-2.5" />
                <Button on:click={ () => showDrawer = false } buttonText="Cancel" className="text-base min-w-full w-full py-2.5 bg-white text-gray-800 border-2 border-gray-800 hover:bg-transparent focus:bg-transparent focus:ring-gray-200" />
            </div>
        </div>
    </div>
</Drawer>
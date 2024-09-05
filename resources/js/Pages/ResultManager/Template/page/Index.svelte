<script>
    import TopHeader from "../../../layouts/top_header.svelte";
    import Layout from "../../../layouts/Layout.svelte";
    import AppContainer from "../../../layouts/app_container.svelte";
    import Select from "../../../components/select.svelte";
    import Button from "../../../components/button.svelte";
    import DataTable from "../../../components/data_table.svelte";
    import SlidePanel from "../../../components/slide_panel.svelte";
    import Input from "../../../components/input.svelte";


    let headings = ['S/N', 'Title', 'Template', 'Total Score', 'Calculate Total Score To', 'Actions']
    let templates = [
        { id: 1, title: 'General Result Template', template: ['CAT 1 (20 Marks)', 'CAT 2 (20 Marks)', 'EXAM (60 Marks)'], totalScore: 100, calculateTotalScoreTo: 100 }
    ];

    let assessmentTypes = ['CAT 1 (20 Marks)', 'CAT 2 (20 Marks)', 'EXAM (60 Marks)'];
    
    let resultTemplate = {
        id: "",
        title: "",
        totalScore: "",
        calculateTotalScoreTo: "",
        template: []
    }

    let shouldShowResultTemplateForm = false;
    let disabled = false;


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
        <TopHeader title="Result Templates" >
            <div>   
                <Button on:click={ showResultTemplateForm } buttonText="Create Result Template" className="text-sm" />   
            </div>
        </TopHeader>

        <AppContainer>
        
            <DataTable { headings } >
                { #each templates as template,index(template.id) }
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
                        <td class="px-6 py-4 text-gray-800 dark:text-white">{ template.title }</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">
                            <ul class="flex flex-col space-y-2">
                                { #each template.template  as assessmentType }
                                    <li class="text-gray-800">{ assessmentType }</li>
                                { /each }
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">{ template.totalScore }</td>
                        <td class="px-6 py-4 text-gray-800 dark:text-white">{ template.calculateTotalScoreTo }</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                            <div class="flex space-x-3">
                                <Button on:click={ () =>  editTemplate(template.id) } buttonText="Edit" className="text-xs min-w-max max-w-min" />
                                <Button on:click={ () =>  deleteTemplate(template.id) } buttonText="Delete" className="text-xs min-w-max max-w-min bg-red-500 hover:bg-red-400 focus:bg-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50" />
                            </div>
                        </td>
                    </tr>
                { /each }
            </DataTable>
        
        </AppContainer>

        <div slot="panel">
            <div class="flex flex-col space-y-6 w-full py-8">
                <div>
                    <Input className="w-full" id="title" value={ resultTemplate.title } on:input={ (e) => resultTemplate.title = e.detail.input } label="Enter Template Title" placeholder="" />
                </div>

                <div>
                    <label for="" class="font-medium text-gray-700">Select Assessment Types</label>
                    <div class="pt-3 space-y-3">
                        { #each assessmentTypes as  type }
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="" id="">
                                <span class="text-gray-800">{ type }</span>
                            </div>
                        { /each }
                    </div>
                </div>
                <div class="flex">
                    <label for="" class="font-bold text-gray-700">Total Score: 0 </label>
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
                </div>
            </div>
        </div>
    </SlidePanel>
</Layout>
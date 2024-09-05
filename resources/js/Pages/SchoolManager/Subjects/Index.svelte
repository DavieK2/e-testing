<script>
    import { onMount } from "svelte";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import { router } from "../../../util";
    import TopHeader from "../../layouts/top_header.svelte";
    import AppContainer from "../../layouts/app_container.svelte";


    let headings = ['SN', 'Course Name', 'Course Code', 'Actions'];

    let subjects = []

    let subjectName = "";
    let subjectCode = "";
    let subjectId;

    let disabled = false;

    onMount( () => {

        getSubjectList();

    })

    let showCreateSubjectSheet = false;

    const closeSheet = () => {
        showCreateSubjectSheet = false
        reset();
    }

    const showSheet = () => showCreateSubjectSheet = true

    const reset = () => {
        subjectId = undefined;
        subjectName = "";
        subjectCode = "";
    }

    const getSubjectList = () => {

        router.get('/api/subjects', {
            onSuccess : (response) => {
               subjects = response.data
            }
        })
    }

    const createSubject = () => {

        disabled = true;

        router.post('/api/subject/create', { subjectName, subjectCode }, {
            onSuccess: (response) => {
                
                getSubjectList();
                reset();
                closeSheet();

                disabled = false

            },
            onError: (response) => {

                disabled = false
                // console.log(response)
            }
        })
    }

    const updateSubject = () => {

        disabled = true;

        router.post('/api/subject/update/'+subjectId, { subjectName, subjectCode }, {
            onSuccess: (response) => {

                getSubjectList();
                reset();
                closeSheet();

                disabled = false;

            },
            onError: (response) => {

                disabled = false
                // console.log(response)
            }
        })
    }

    const editSubject = (id, name, code) => {
        subjectId = id
        subjectName = name
        subjectCode = code
        showSheet();
    }

    const deleteSubject = (id, name) => {
        subjectId = id
        subjectName = name
    }

    $: disabled = ( subjectName.length === 0 );

</script>

<Layout>
    <SlidePanel title="Create New Subject" showSheet={ showCreateSubjectSheet } on:onpanelstatus={ closeSheet }>
        <TopHeader title="Subjects" >
            <div>
                <Button on:click={ showSheet } buttonText="New Subject" className="text-sm" />
            </div>
        </TopHeader>

        <AppContainer>
        
            <DataTable { headings } >
                { #each subjects as subject,index(subject.subjectId) }
                    <tr>
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ subject.subjectName }</td>
                        <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ subject.subjectCode }</td>
                        <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                            <div class="flex space-x-3">
                                <Button on:click={ () => editSubject(subject.subjectId, subject.subjectName, subject.subjectCode) } buttonText="Edit" className="text-xs w-20" />
                                <Button buttonText="Delete" className="text-xs w-20 bg-red-500 hover:bg-red-400 focus:bg-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50" />
                            </div>
                        </td>
                    </tr>
                {/each}
            </DataTable>
        
        </AppContainer>

        <div slot="panel">
            <div class="flex flex-col space-y-6 p-3">
                <div>
                    <Input value={ subjectName } on:input={ (e) => subjectName = e.detail.input }  label="Enter Subject Name" />
                </div>
                <div>
                    <Input value={ subjectCode } on:input={ (e) => subjectCode = e.detail.input }  label="Enter Subject Code" />
                </div>
                <div class="w-20">
                    { #if subjectId }
                        <Button { disabled } on:click={ updateSubject } buttonText="Update Subject" className="text-sm"/>
                    { :else }
                        <Button { disabled } on:click={ createSubject } buttonText="Save Subject" className="text-sm"/>
                    { /if }
                </div>
            </div>
    </SlidePanel>
</Layout>
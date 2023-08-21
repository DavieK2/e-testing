<script>
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";


    let headings = ['SN', 'Class Name', 'Total Students', 'Actions']
</script>
<Layout>
    <div class="mt-28 px-3">
        <div class="container px-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="badge" classList="h-6 w-6" />
                    <span class="mx-2 text-2xl font-semibold text-gray-800">Classes</span>
                </div>
                <div>
                    <Button buttonText="Create New Class" className="text-sm" />
                </div>
            </div>
        </div>
        <DataTable { headings } >
            <tr>
                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">Students</td>
                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">Students</td>
                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">Students</td>
                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">Students</td>
            </tr>
        </DataTable>
    </div>
</Layout>

<SlidePanel title="Create New Class" showSheet={ true } >
    <div class="flex flex-col space-y-6 p-3">
        <div>
            <Input label="Enter Class Name" />
        </div>
        <div class="w-20">
            <Button buttonText="Save" className=""/>
        </div>
    </div>
</SlidePanel>
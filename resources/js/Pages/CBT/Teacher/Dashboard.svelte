<script>
    import { onMount } from "svelte";
    import DataTable from "../../components/data_table.svelte";
    import Dropdown from "../../components/dropdown.svelte";
    import Layout from "./components/layout.svelte";
    import { router } from "../../../util";
    import { inertia } from "@inertiajs/svelte"


    let headings = ['S/N', 'Class', 'Actions'];

    let classes = [];

    onMount(() => {
        router.get('/api/get-classes', {
            onSuccess : (res) => {
                classes = res.data
            }
        })
    })

</script>

<Layout>
    <div class="px-6 my-28">
        <div class="container px-4">
            <h3 class="text-lg font-semibold">Classes</h3>
        </div>
        <DataTable { headings } >
            { #each classes as grade,index(grade.class_code) }
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ index + 1  }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">{ grade.class_name }</td>
                    <td class="px-4 py-4 text-sm text-gray-800 dark:text-gray-300 whitespace-nowrap">
                        <div class="w-40">
                            <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border  border-gray-300 text-gray-600">
                                <a use:inertia href={ '/teacher/class-subjects/' + grade.class_code } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">View Subjects</a>
                            </Dropdown>
                        </div>
                    </td>
                </tr>
            { /each }
        </DataTable>
    </div>
</Layout>
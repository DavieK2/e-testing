<script>
    import { onMount } from "svelte";
    import { router } from "../../../util";
    import Button from "../../components/button.svelte";
    import DataTable from "../../components/data_table.svelte";
    import Icons from "../../components/icons.svelte";
    import Input from "../../components/input.svelte";
    import Select from "../../components/select.svelte";
    import SlidePanel from "../../components/slide_panel.svelte";
    import Layout from "../../layouts/Layout.svelte";
    import Dropdown from "../../components/dropdown.svelte";


    let headings = ['SN', 'Name', 'Class', 'Student Code', 'Actions']

    let classes = [];

    let firstName;

    let surname;

    let classId;

    let subjects = [];

    let selectedSubjects = [];

    let students = [];

    let slideFormState;

    let slidePanelTitle;

    let showStudentForm

    let studentData = {
        id : "",
        name : "",
        class : "",
        studentCode : ""
    }

    const reset = () => {

        studentData = {
            id : "",
            name : "",
            class : "",
            studentCode : ""
        }
    }

    const panelState = {
        addNewStudent : "Add New Student",
        edit : "Edit Student Info",
        assignSubjects : "Assign Subjects"
    }


    onMount(() => {

        getStudents();
        getSubjects();

        router.get('/api/classes', {

            onSuccess : (res) => {
                classes = res.data.flatMap((grade) => [{ placeholder : grade.class_name, value : grade.id }])
            }
        })
    })


    const getStudents = () => {

        router.get('/api/students', {
            onSuccess : (res) => {
                students = res.data
            }
        })
    }

    const getSubjects = () => {

        router.get('/api/subjects', {
            onSuccess : (res) => {
                subjects = res.data
            }
        })
    }

    const createStudent = () => {

        router.post('/api/student/create', { classId: classId.value, firstName: firstName.value, surname: surname.value }, {
            onSuccess : (res) => {
                students = res.data
            }
        })

        getStudents();

        closeSheet();
    }


    const showSheet = (state) => {

        slideFormState = state;

        if(slideFormState === panelState.addNewStudent){
            slidePanelTitle = panelState.addNewStudent
        }

        if(slideFormState === panelState.edit){
            slidePanelTitle = panelState.edit
        }

        if(slideFormState === panelState.assignSubjects){
            slidePanelTitle = panelState.assignSubjects
        }

        showStudentForm = true
    };

    const closeSheet = () => {

        showStudentForm = false
        reset()

    };

    const assignSubjects = (index) => {

        studentData.id = students[index].studentId

        router.get('/api/student/assigned-subjects/' + studentData.id, {
            onSuccess : (res) => {
                selectedSubjects = res.data
            }
        })

        showSheet(panelState.assignSubjects);
    }

    $: isSelected = (subjectId) => {
        return selectedSubjects.some((selected) => selected.subjectId == subjectId);
    }

    const selectSubject = (subject) => {

        if(isSelected(subject.subjectId)){
            selectedSubjects = selectedSubjects.filter((selected) => selected.subjectId != subject.subjectId);
            return ;
        }

        selectedSubjects.push(subject);
        selectedSubjects = selectedSubjects;

    }

    const assignSubjectToStudent = () => {

        router.post('/api/student/assign-subjects', { studentId : studentData.id, subjects : selectedSubjects }, {

            onSuccess : (res) => {

                closeSheet();
            }
        })
    }



</script>
<Layout>
    <div class="mt-28 px-3">
        <div class="container px-4 mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex space-x-3 items-center">
                    <Icons icon="badge" className="h-6 w-6" />
                    <span class="mx-2 text-lg font-semibold text-gray-800">Students</span>
                </div>
                <div>
                    <Button on:click={ () => showSheet(panelState.addNewStudent) } buttonText="Add New Student" className="text-sm" />
                </div>
            </div>
        </div>
      
        <DataTable { headings } >
            { #each students as student, index }
                <tr>
                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ index + 1 }</td>
                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ student.name }</td>
                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{ student.class }</td>
                    <td class="px-4 py-4 text-sm text-blue-500 dark:text-gray-300 whitespace-nowrap">{ student.studentCode }</td>
                    <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                        <div class="w-40">
                            <Dropdown arrowColor="fill-gray-600" placeholder="Actions" className="bg-white border  border-gray-300 text-gray-600">
                                <button on:click={ () => assignSubjects(index) } class="hover:bg-gray-100 p-3 text-sm rounded transition text-left">Add Subjects</button>
                            </Dropdown>
                        </div>
                    </td>
                </tr>
            { /each }
        </DataTable>
    </div>
</Layout>

<SlidePanel title={ slidePanelTitle } showSheet={ showStudentForm } on:close-button={ closeSheet }>
    { #if ( slideFormState === panelState.addNewStudent ) || ( slideFormState === panelState.edit )  }
        <div class="flex flex-col space-y-6 p-3">
            <div>
                <Input bind:this={ firstName } value={ studentData.name } label="Enter Student First Name" />
            </div>

            <div>
                <Input bind:this={ surname } value={ studentData.name } label="Enter Student Surname" />
            </div>

            <div>
                <Select bind:this={ classId } value={ studentData.class } options={ classes } placeholder="Select Class" label="Select Student Class" className="text-sm"  />
            </div>

            <div class="w-20">
                <Button on:click={ createStudent } buttonText="Save" className=""/>
            </div>
        </div>
    { /if }

    { #if ( slideFormState === panelState.assignSubjects ) }
        <div class="flex flex-col space-y-3 p-3">
            <p class="text-gray-800 font-semibold pb-6">Subjects</p>

            <div class="space-y-3">
                { #if subjects.length === 0 }
                    <div class="flex w-full py-6">
                        <p class="italic text-gray-500">No subjects to add</p>
                    </div>
                { :else }
                    { #each subjects as subject }
                        <div class="flex space-x-2 items-center w-full">
                            <button  on:click={ () => selectSubject(subject) } class={`flex items-center shrink-0 justify-center h-11 w-11 border ${ isSelected(subject.subjectId) ? 'border-green-700' : 'border-gray-300' } rounded-lg`}>
                                <Icons icon="check" className={`${ isSelected(subject.subjectId) ? "stroke-green-700" : "stroke-gray-300" }`} />
                            </button>
                            <div class="w-full">
                                <button type="button" class={`flex p-3 border ${ isSelected(subject.subjectId) ? 'border-green-700' : 'border-gray-300' }  w-full rounded-lg items-center justify-between space-x-2`}>
                                    <span class={`${ isSelected(subject.subjectId) ? "text-green-700" : "text-gray-400" }`} >{ subject.subjectName }</span>
                                </button>
                            </div>
                        </div>
                    { /each }
                {/if}
            </div>

            <div class="pt-10 w-40">
                <Button on:click={ assignSubjectToStudent } buttonText="Assign Subjects" />
            </div>
        </div>
    { /if }
  
</SlidePanel>
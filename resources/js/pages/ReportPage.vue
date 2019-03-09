<template>
    <component :is="layout">
        <div v-if="loaded">
            <h2> Info by each imported files </h2>

            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">File name</th>
                        <th scope="col">Import date</th>
                        <th scope="col">Import count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in importedByFiles">
                        <td>{{ item.file_name }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td>{{ item.count }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h2> Info by each subscription</h2>

            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Subscription name</th>
                        <th scope="col">Count subscribers</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in subscribesInfo">
                        <td>{{ item.name }}</td>
                        <td>{{ item.count }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <h2> Info by each file which having count more than {{ limit }} subscribers</h2>

            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">File name</th>
                        <th scope="col">Import date</th>
                        <th scope="col">Import count</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in importedByFilesCount">
                        <td>{{ item.file_name }}</td>
                        <td>{{ item.updated_at }}</td>
                        <td>{{ item.count }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </component>
</template>

<script>
    export default {
        name: "ReportPage",
        data() {
            return {
                loaded: false,
                report: {}
            }
        },
        created() {
            axios.get('report').then(responce => {
                this.loaded = true;
                this.importedByFiles = responce.data.importedByFiles;
                this.subscribesInfo = responce.data.subscribesInfo;
                this.importedByFilesCount = responce.data.importedByFilesCount;
                this.limit= responce.data.limit;
            });
        }
    }
</script>

<style scoped>

</style>

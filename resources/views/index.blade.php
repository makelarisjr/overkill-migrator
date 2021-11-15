<html>
<head>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900">
<div id="app" class="flex flex-col justify-center items-center m-auto h-full text-gray-400">
    <p class="text-5xl mt-5">Overkill Migrator</p>
    <div
        :class="[vms.length >= 4 ? 'grid-cols-4' : `grid-cols-${vms.length}`]"
        class="grid gap-4 mt-3 mx-13 px-14 overflow-y-auto py-5">
        <div v-for="vm of vms" class="flex flex-col bg-gray-800 rounded shadow-lg p-2 w-96 text-center">
            <p class="mt-2 text-2xl">{{ vm.name }}</p>
            <p>{{ vm.src_vc.host }} -> {{ vm.dst_vc.host }}</p>
            <p class="text-sm">
                {{ getStatus(vm.status) }}
            </p>
            <div v-if="vm.status === 'idle'" class="my-2">
                <button
                    @click="migrateVM(vm.id)"
                    class="shadow border border-gray-900 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                >
                    Start Migration
                </button>
            </div>
            <div v-if="!['failed', 'idle'].includes(vm.status)" class="overflow-hidden h-4 my-2 text-xs flex rounded-full bg-gray-700">
                <div
                    :style="{'width': `${vm.percentage}%`, 'transition': 'width 2s'}"
                    class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gray-500"
                >
                    {{ vm.percentage }}%
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            vms: []
        },
        mounted() {
            this.fetchVMs();
            setInterval(
                this.fetchVMs.bind(this),
                5*1000
            );
        },
        methods: {
            fetchVMs() {
                axios
                    .get('/api/vms')
                    .then(({ data }) => {
                        this.vms = data.data;
                    })
            },
            migrateVM(vmId) {
                axios
                    .post(`/api/vms/${vmId}/migrate`)
                    .then(() => {
                        this.fetchVMs();
                    })
            },
            getStatus(status) {
                switch(status) {
                    case 'idle':
                        return 'Idle';
                    case 'waiting':
                        return 'Waiting';
                    case 'cloning':
                        return 'Cloning VM';
                    case 'migrating':
                        return 'Migrating VM';
                    case 'completed':
                        return 'Migration Completed';
                    case 'failed':
                        return 'Failed';
                    default:
                        return status;
                }
            }
        }
    })
</script>
</html>

<template>
    <div class="uppercase text-xs font-bold tracking-widest px-2 py-1 rounded-full" :class="statusClass">
        {{ status }}
    </div>
</template>

<script>
    export default {
        props: ['status'],

        computed: {
            statusClass() {
                if (this.status === 'sent') {
                    return 'text-green-900 bg-green-200';
                }

                if (this.status === 'posted') {
                    return 'text-yellow-900 bg-yellow-200';
                }

                if (this.status === 'failed') {
                    return 'text-red-900 bg-red-200';
                }

                return 'text-gray-900 bg-gray-200';
            }
        }
    }
</script>

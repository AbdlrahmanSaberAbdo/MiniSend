<template>
    <div class="p-8 w-full lg:px-24 lg:py-16">
        <div class="flex flex-col space-y-8 lg:space-y-16" v-if="email">
            <div>
                <div class="flex justify-between items-center tracking-wide">
                    <h1 class="text-2xl text-gray-500 lg:text-4xl">{{ email.subject }}</h1>
                    <div class="flex flex-col space-x-4 items-end text-right lg:items-center lg:flex-row">
                        <status-badge :status="email.status"></status-badge>
                        <span class="text-base lg:text-xl">{{ email.posted_at }}</span>
                    </div>
                </div>

                <p class="mt-2 text-lg text-gray-400 lg:text-xl">
                    From
                    <span class="text-indigo-400">{{ email.sender }}</span>
                    to
                    <span class="text-indigo-400">{{ email.recipient }}</span>
                </p>
            </div>

            <div class="text-xl lg:text-2xl text-gray-600">
                <p class="text-base uppercase text-gray-400 font-semibold">Text content:</p>
                {{ email.text }}
            </div>

            <div>
                <p class="text-base uppercase text-gray-400 font-semibold">HTML content:</p>
                <div class="text-xl text-gray-600 lg:text-2xl" v-html="email.html"></div>
            </div>

            <div v-if="email.attachments.length > 0">
                <p class="text-base uppercase text-gray-400 font-semibold">{{ email.attachments.length }} Attachments:</p>
                <div class="flex space-x-8 flex-wrap justify-end lg:justify-start">
                    <div
                        class="flex px-6 py-4 border-2 border-gray-200 shadow-sm bg-gray-50 rounded-lg items-center space-x-4 cursor-pointer mb-4"
                        v-for="attachment in email.attachments"
                        :key="attachment.id"
                        @click="download(attachment)"
                    >
                        <div class="flex flex-col">
                            <p>{{ attachment.filename }}</p>
                            <p>{{ attachment.filesize }}</p>
                        </div>
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-full flex justify-center items-center" v-else>
            <div class="flex flex-col items-center space-y-8 lg:space-y-16">
                <img class="h-32 lg:h-64 w-auto" src="/images/envelope_undraw.svg" alt="">
                <p class="text-xl lg:text-2xl text-center">
                    You have not selected an email yet. Click on one of them at your left to see its content.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import StatusBadge from "./StatusBadge";
    export default {
        components: {StatusBadge},
        props: ['email'],

        methods: {
            download(attachment) {
                axios.get('/api/v1/attachments/download', {
                    responseType: 'arraybuffer',
                    params: {
                        attachment_id: attachment.id
                    }
                })
                    .then((response) => {
                        let blob = new Blob([response.data], { type: attachment.media_type });
                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = attachment.filename;
                        link.click();
                    })
                    .catch((error) => console.error(error.response));
            },
        }
    }
</script>

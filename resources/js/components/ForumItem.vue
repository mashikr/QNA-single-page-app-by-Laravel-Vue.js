<template>
    <div class="card mt-2">
        <div class="card-header">
            <router-link :to="{ name: 'forum', params: { slug: question.path }}" class="h4">{{ question.title }}</router-link> <br>
            <small>{{ question.user }} said {{ question.created_at }}</small>
        </div>
        <div v-html="body" class="card-body">
        </div>
    </div>
</template>

<script>
import md from 'marked';
export default {
    props: ['question'],
    computed: {
        body() {
            return md.parse(this.question.body);
        }
    }
}
</script>
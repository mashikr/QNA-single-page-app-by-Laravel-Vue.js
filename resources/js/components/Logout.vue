<template>
    <div>

    </div>
</template>
<script>
export default {
    created() {
        if(confirm("Are you sure to logout?")) {
            _User.logout();
        } else {
            window.history.back();
        }
    }
}
</script>

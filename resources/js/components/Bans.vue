<template>
    <div class="table-responsive">
        <div class="row">
            <div class="col-sm-6 col-md-3 mg-b-10 mg-l-auto">
                <input class="form-control bans-search" placeholder="Поиск" type="text">
            </div>
        </div>
        <table class="table data-bans">
            <thead>
            <tr>
                <th>Дата</th>
                <th>Ник</th>
                <th>Причина</th>
                <th>Админ</th>
                <th>Истекает</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :class="{'table table-teal': item.is_active}">
                <th scope="row">{{ item.created }}</th>
                <td>{{ item.player_nick }}</td>
                <td>{{ item.ban_reason }}</td>
                <td>{{ item.admin_nick }}</td>
                <td>{{ item.expire_at }}</td>
            </tr>
            <tr>
                <td colspan="5">Банов нет</td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    export default {
        name: "Bans",
        data() {
            return {
                items: [],
                query: '',
            }
        },
        mounted() {
            this.search();
        },
        methods: {
            search() {
                axios.post('/bans/search', {q: this.query})
                    .then(r => {
                        this.items = r.data;
                    })
                    .catch(e => {})
                    .finally(() => {});
            }
        }
    }
</script>

<style scoped>

</style>

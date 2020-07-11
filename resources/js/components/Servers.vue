<template>
    <div class="row">
        <div v-for="server in servers" class="col-lg-6 mb-4">
            <div class="card card-profile">
                <div class="card-body">
                    <div class="media">
                        <img :src="getImageUrl(server)"
                             onerror="/images/nomap.jpg"
                             width="120" height="120">
                        <div class="media-body">
                            <h3 class="card-profile-name">
                                <a class="text-dark" :href="'/servers/' + server.id">
                                    {{ server.info ? server.info.HostName : 'Нет информации'}}
                                </a>
                            </h3>
                            <p class="mb-1">{{ server.address }}</p>
                            <b>Онлайн: {{ server.info ? server.info.Players : '0' }}/{{ server.info ? server.info.MaxPlayers : '0' }}</b>
                        </div>
                    </div>
                </div>
                <div v-if="false" class="card-footer">
                    <div class="list-group list-group-flush w-100">
                        <div class="list-group-item bg-gray-200">
                            <div class="media">
                                <div class="media-body ml-0 d-flex">
                                    <b>Игрок</b>
                                    <b class="ml-auto w-25 text-right">Убийств</b>
                                    <b class="w-25 text-right">Время</b>
                                </div>
                            </div>
                        </div>

                        <div v-if="server.players"
                                 v-for="player in server.players" class="list-group-item">
                                <div class="media">
                                    <div class="media-body ml-0 d-flex">
                                        <b>{{ player.Name }}</b>
                                        <span class="ml-auto w-25 text-right">{{ player.Frags }}</span>
                                        <span class="w-25 text-right">{{ player.TimeF }}</span>
                                    </div>
                                </div>
                            </div>
                        <div v-else class="list-group-item">
                            <div class="media">
                                <div class="media-body ml-0 d-flex">
                                    <b>Игроков нет.</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Servers",
        data() {
            return {
                servers: []
            }
        },
        mounted() {
            this.list();
        },
        methods: {
            list() {
                axios.get('/servers/list')
                    .then(r => {
                        this.servers = r.data;
                        this.servers.forEach((el, idx, arr) => {
                            this.info(el);
                        });
                    })
            },
            info(server) {
                axios.get('/servers/info/' + server.id)
                    .then(r => {
                        if (r.data.info) {
                            this.$set(server, 'info', r.data.info);
                        }

                        if (r.data.players) {
                            this.$set(server, 'players', r.data.players);
                        }
                    })
                    .catch()
            },
            getImageUrl(server) {
                if (server.info) {
                    return '//image.gametracker.com/images/maps/160x120/cs/' + server.info.Map + '.jpg';
                }
            }
        }
    }
</script>

<style scoped>

</style>

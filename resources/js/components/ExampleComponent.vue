<template>
    <div class="flex h-full w-full bg-gray-600">
        <div class="flex m-4 shadow-lg bg-gray-500 rounded">
            <column :details="player" :index="index" :key="index" v-for="(player, index) in sortedByScore"></column>
        </div>
        <div class="flex-1 bg-gray-600">
            <div class="grid grid-cols-3 gap-4 m-4">
                <div v-for="player in players">
                    <player :key="player.id" :details="player"></player>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DonutChart from "./DoughNut";
import Player from "./Player";
import Column from "./Column"

export default {
    components: {Column, Player, DonutChart},
    data() {
        return {
            players: [],
            sortedByScore: []
        }
    },
    methods: {
        refresh: function () {
            axios.get('/players').then(resp => {
                this.players = resp.data.sort(function (a, b) {
                    if (a.beverages.length === 0 && b.beverages.length === 0)
                        return 0;
                    if (a.beverages.length === 0 && b.beverages.length > 0)
                        return 1;
                    if (a.beverages.length > 0 && b.beverages.length === 0)
                        return -1;

                    let aLatest = a.beverages[a.beverages.length - 1];
                    let bLatest = b.beverages[b.beverages.length - 1];

                    if (aLatest.completed_at != null && bLatest.completed_at == null) {
                        return 1;
                    }
                    if (aLatest.completed_at == null && bLatest.completed_at != null) {
                        return -1;
                    }

                    return Date.parse(aLatest.started_at) - Date.parse(bLatest.started_at)
                })
                let clonedPlayers = _.clone(this.players);
                clonedPlayers.sort((a, b) => b.total_score - a.total_score);
                this.sortedByScore = clonedPlayers;
            });
        }
    },
    computed: {
        sortByScore: function () {
            let players = _.clone(this.players);
            players.sort((a, b) => b.total_score - a.total_score);
            return players;
        }
    },
    mounted() {
        this.refresh();
        setInterval(function () {
            this.refresh();
        }.bind(this), 10000)
    }
}
</script>

<style>

</style>

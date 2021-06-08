<template>
    <div class="flex flex-col justify-center flex items-center shadow-lg bg-gray-500 rounded">
        <div class="flex items-center flex-col h-80">
            <div class="text-white text-4xl mb-4">{{ details.name }}</div>
            <div class="flex justify-center items-center flex-1" v-if="latest == null">
                <div class="flex flex-col items-center text-gray-300">
                    <i class="text-3xl fas fa-hourglass"></i>
                    <span class="text-lg">Waiting for player to fill up their glass</span>
                </div>
            </div>
            <div v-else class="flex flex-1">
                <donut-chart :percent="percent" :background-color="backgroundColor"
                             :foregroundColor="foregroundColor" :time="time"></donut-chart>
                <div class="flex flex-col justify-between my-4 ml-2">
                    <div class="flex gap-y-2 flex-col flex-1">
                        <div class="outer" v-for="i in latest.cost">
                            <div class="pill"></div>
                        </div>
                    </div>
                    <div class="bg-gray-300 rounded-lg flex justify-between items-center p-2 opacity-80 shadow-lg">
                        <span
                            :class="{'text-red-800': backgroundColor === '#cc1f1a', 'text-yellow-800': backgroundColor === '#f2d024', 'text-green-800': backgroundColor === '#1f9d55'}"
                            v-html="left(timeLeft)"></span>
                        <i :class="{'fa-sad-cry text-red-800': backgroundColor === '#cc1f1a', 'fa-meh text-yellow-800': backgroundColor === '#f2d024', 'fa-laugh-beam text-green-800': backgroundColor === '#1f9d55'}"
                           class="fas text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DonutChart from "./DoughNut";

export default {
    name: "Player",
    components: {DonutChart},
    props: {
        details: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            time: 0,
            percent: 0,
            backgroundColor: '',
            foregroundColor: '',
            timeLeft: 0
        }
    },
    methods: {
        getLatest: function () {
            if (this.details.beverages.length === 0)
                return null;
            return this.details.beverages.find(x => x.completed_at == null)
        },
        remainingTime: function () {
            if (this.getLatest() == null)
                return;
            let beverage = this.details.beverages.find(x => x.completed_at == null)
            let startTime = beverage.started_at;
            let secondsSinceStart = (new Date - Date.parse(startTime)) / 1000;
            let hours = Math.floor(secondsSinceStart / 60 / 60);
            let minutes = Math.floor((secondsSinceStart / 60) - hours * 60);
            let seconds = Math.floor(secondsSinceStart % 60);

            this.updateChart(secondsSinceStart, beverage.cost)

            if (hours < 1)
                return String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');
            return hours + ":" + String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0');
        },
        updateChart: function (seconds, cost) {
            // cost == 1, 0-15 grøn
            // cost == 1, 15-20 gul
            // cost == 1, 20+ rød
            let greenHex = '#1f9d55'
            let yellowHex = '#f2d024'
            let redHex = '#cc1f1a'
            let greenLimit = 15 * 60 * cost;
            let yellowLimit = 20 * 60 * cost;
            if (seconds <= greenLimit) {
                this.timeLeft = greenLimit - seconds;
                this.foregroundColor = yellowHex;
                this.backgroundColor = greenHex;
                this.percent = (seconds / greenLimit) * 100;
                return;
            }
            if (seconds <= yellowLimit) {
                this.timeLeft = yellowLimit - seconds;
                this.foregroundColor = redHex;
                this.backgroundColor = yellowHex;
                this.percent = ((seconds - greenLimit) / (yellowLimit - greenLimit)) * 100;
                return;
            }
            this.timeLeft = yellowLimit - seconds;
            this.foregroundColor = redHex;
            this.backgroundColor = redHex;
            this.percent = 0;

        },
        left(seconds) {
            if (seconds > 0) {
                if (seconds < 60)
                    return Math.floor(seconds) + " seconds left"
                return Math.ceil(seconds / 60) + " minutes left";
            }
            let secondsOverTime = Math.abs(seconds);
            if (secondsOverTime < 60)
                return Math.floor(secondsOverTime) + " seconds<br>over time"
            return Math.floor(secondsOverTime / 60) + " minutes<br>over time";
        }
    }
    ,
    computed: {
        latest: function () {
            return this.getLatest();
        }
    }
    ,
    mounted() {
        this.time = this.remainingTime();
        setInterval(function () {
            this.time = this.remainingTime();
        }.bind(this), 1000)
    }
}
</script>

<style>
.outer {
    margin: 0 10px;
    width: 7.5vw;
    height: 34px;
    border-radius: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pill {
    width: 100%;
    position: relative;
    height: 100%;
    bottom: 1px;
    left: 1px;
    background-color: rgba(95, 2, 31, 1);
    border-radius: 20px;
    box-shadow: inset 5px -10px 15px 5px rgba(25, 25, 25, 0.6), -4px 4px 6px 2px rgba(0, 0, 0, 0.4);
}
</style>

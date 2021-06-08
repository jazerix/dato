<template>
    <div class="mx-4">
        <div class="text-white flex justify-center font-extrabold">
            <span>{{ index + 1 }}</span>
        </div>
        <div class="diller my-1 flex justify-center items-center" v-for="jeton in scoreArray" :class="jeton">
            <i class="text-sm fas fa-beer"></i>
        </div>
        <div class="text-white mt-2 flex justify-center">
            <span class="diller2">{{ details.name }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Column",
    props: {
        details: {
            type: Object,
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            score: []
        }
    },
    computed: {
        scoreArray: function() {
            let test = [];

            for (let i = 0; i < this.details.beverages.length; i++) {
                let beverage = this.details.beverages[i];
                if (beverage.completed_at == null)
                    break;

                let greenLimit = beverage.cost * 60 * 15;
                let yellowLimit = beverage.cost * 60 * 20;
                let elapsed = (Date.parse(beverage.completed_at) - Date.parse(beverage.started_at))/1000;

                let result = ""
                if (elapsed <= greenLimit) {
                    result = 'bg-green-800'
                } else if (elapsed <= yellowLimit) {
                    result = 'bg-yellow-800'
                } else {
                    result = 'bg-red-800'
                }
                for (let j = 0; j < beverage.cost; j++) {
                    test.push(result)
                }
            }

            let remaining = 30 - test.length;
            for (; remaining > 0; remaining--) {
                test.push("opacity-10 bg-green-800")
            }

            return test.reverse()
        }
    },
    mounted() {
        let test = [];

        for (let i = 0; i < this.details.beverages.length; i++) {
            let beverage = this.details.beverages[i];
            if (beverage.completed_at == null)
                break;

            let greenLimit = beverage.cost * 60 * 15;
            let yellowLimit = beverage.cost * 60 * 20;
            let elapsed = (Date.parse(beverage.completed_at) - Date.parse(beverage.started_at))/1000;

            let result = ""
            if (elapsed <= greenLimit) {
                result = 'bg-green-800'
            } else if (elapsed <= yellowLimit) {
                result = 'bg-yellow-800'
            } else {
                result = 'bg-red-800'
            }
            for (let j = 0; j < beverage.cost; j++) {
                test.push(result)
            }
        }

        let remaining = 30 - test.length;
        for (; remaining > 0; remaining--) {
            test.push("opacity-10 bg-green-800")
        }

        this.score = test.reverse()
    }
}
</script>

<style>

.diller {
    height: 2.5vh;
    width: 2.5vh;
    border-radius: 50%;
    color: #F2F3F4;

}

.diller2 {
    writing-mode: vertical-rl;
    text-orientation: mixed;
}

</style>

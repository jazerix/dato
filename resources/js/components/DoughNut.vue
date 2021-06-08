<template>
    <svg width="250" height="250" version="1.1" xmlns="http://www.w3.org/2000/svg"
         viewBox="-25 -25 250 250">

        <!-- Background circle -->
        <path v-bind:d="dBg"
              fill="transparent"
              :stroke="backgroundColor"
              :stroke-width="strokeWidth"/>

        <!-- Move to start position, start drawing arc -->
        <path v-bind:d="d"
              fill="transparent"
              :stroke="foregroundColor"
              :stroke-width="strokeWidth"/>
        <text x="100" text-anchor="middle" font-size="36" fill="white" y="112" v-text="time"></text>
    </svg>
</template>

<script>
export default {
    name: 'donut-chart',
    props: ['percent', 'foreground-color', 'background-color', 'time'],
    replace: true,
    data: function () {
        return {
            radius: 90,
            strokeWidth:60
        }
    },
    computed: {
        // If more than 50% filled we need to switch arc drawing mode from less than 180 deg to more than 180 deg
        largeArc: function () {
            return this.percent < 50 ? 0 : 1;
        },
        // Where to put x coordinate of center of circle
        x: function () {
            return 100;
        },
        // Where to put y coordinate of center of circle
        y: function () {
            return 100 - this.radius;
        },
        // Calculate X coordinate of end of arc (+ 100 to move it to middle of image)
        // add some rounding error to make arc not disappear at 100%
        endX: function () {
            return -Math.sin(this.radians) * this.radius + 100 - 0.0001;
        },
        // Calculate Y coordinate of end of arc (+ 100 to move it to middle of image)
        endY: function () {
            return Math.cos(this.radians) * this.radius + 100;
        },
        // Calculate length of arc in radians
        radians: function () {
            var degrees = (this.percent / 100) * 360
            var value = degrees - 180; // Turn the circle 180 degrees counter clockwise

            return (value * Math.PI) / 180;
        },
        // If we reach full circle we need to complete the circle, this ties into the rounding error in X coordinate above
        z: function () {
            return this.percent == 100 ? 'z' : '';
        },
        dBg: function () {
            return "M " + this.x + " " + this.y + " A " + this.radius + " " + this.radius + " 0 1 1 " + (this.x - 0.0001) + " " + this.y + " z";
        },
        d: function () {
            return "M " + this.x + " " + this.y + " A " + this.radius + " " + this.radius + " 0 " + this.largeArc + " 1 " + this.endX + " " + this.endY + " " + this.z;
        }
    }
}
</script>

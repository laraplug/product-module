<template>
    <el-input
        v-model="displayValue"
        @blur="onBlur"
        @focus="onFocus">
    </el-input>
</template>

<script>
    export default {
        data: function() {
            return {
              inputFocused: false
            }
        },
        props: {
            value: {
                type: Number,
                default: 0,
                twoWay: true
            },
            prefix: {
                type: String,
                default: ''
            },
            suffix: {
                type: String,
                default: ''
            }
        },
        methods: {
            onBlur() {
                this.inputFocused = false
            },
            onFocus() {
                this.inputFocused = true
            }
        },
        computed: {
          displayValue: {
            get: function() {
              if (this.inputFocused) {
                return this.value ? this.value.toString() : this.value
              } else {
                return this.prefix + (this.value ? this.value.toLocaleString() : this.value) + this.suffix
              }
            },
            set: function(value) {
                value = parseFloat(value.toString().replace(/[^\d\.]/g, ""))
                this.$emit('input', isNaN(value) ? 0 : value)
            }
          }
        }
    };
</script>

<template>
  <div class="cell">
    <input :readonly="editable" @change="change" v-model="cell" type="text" >
  </div>
</template>

<script>
    export default {
        name: "Cell",
        data () {
            return {
                cell: this.value,
                editable: this.readonly || false
            }
        },
        props: [
            'value',
            'position',
            'readonly'
        ],
        methods: {
            change () {
                if(isNaN(this.cell)) {
                    alert('Please enter a number');
                    return;
                }
                let cell = {
                    position: this.position,
                    value: this.cell
                };
                this.$emit('cellChange', cell);
            }
        }

    }
</script>

<style scoped>

  .cell {
    display: inline-block;
    padding: 10px 0;
    border: 1px solid #ddd;
    text-align: center;
    width: 50px;
  }
  .cell:focus-within {
    background: white;
  }

  .cell input {
    border: 1px solid #ddd;
    display: inline;
    width:50%;
    padding:5px;
    text-align:center;

  }
  input:focus {
    border: none;
    outline:none;
  }

</style>
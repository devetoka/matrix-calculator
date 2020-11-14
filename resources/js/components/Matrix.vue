<template>
  <div>
    <div class="cell-holder">
        <label>
          Row
          <input type="number" @keyup="loadMatrix"  placeholder="enter num of row" v-model="row">
        </label>
      <label>
        x
      </label>
      <label>
        Column
        <input type="number" @keyup="loadMatrix" placeholder="enter num of column" v-model="column">
      </label>
      <div   :key="i" v-for="(mat,i) in matrix">
        <cell @cellChange="updateMatrix" :key="j" :position="setRef(i,j)" :value="m" v-for="(m, j) in mat">

        </cell>
      </div>
    </div>
  </div>
</template>

<script>

  import Cell from "./Cell";
    export default {
        name: "Matrix",
        data () {
            return {
                message: 'I am a matrix',
                row:  2,
                column:  2,
                matrix:  []
            }
        },

        components: {
            Cell
        },
        methods: {
            loadMatrix() {
                let matrix = [];
                for(let i = 0; i < this.row; i++){
                    let column = [];
                    for(let j = 0; j < this.column; j++){
                        column.push(0);
                    }
                    matrix.push(column);
                }
                this.matrix = matrix;
                this.$emit('matrixChange', this.matrix);
            },
            updateMatrix (value) {
                console.log(this.matrix);
               let position = value.position.split('');
               let row = position[0];
               let column = position[1];
               this.matrix[row][column] = value.value;
                this.$emit('matrixChange', this.matrix);
            },
            setRef(i,j) {
                return i + '' + j;
            }
        },
        mounted() {
            this.loadMatrix();
        }
    }
</script>

<style scoped>
  input {
    border: 1px solid #ddd;
    display: inline;
    width:50px;
    padding:5px;
    margin-bottom:20px;
    text-align:center;

  }

  .cell-holder {
    text-align: center;
    border: 1px solid #eee;
    padding: 20px;
    margin: 20px;
    background: #eaeaea;
  }

  label {
    margin: 2px 5px;
  }


</style>
<template>
  <div class="calculator">
    <div id="heading">
      <h1>Matrix Multiplicator</h1>
    </div>
    <div class="matrix-holder" >
      <h3>First Matrix</h3>
      <matrix @matrixChange="updateMatrixOne"></matrix>
    </div>
    <div class="matrix-holder" >
      <h3>Second Matrix</h3>
      <matrix @matrixChange="updateMatrixTwo"></matrix>
    </div>

    <div class="btn-holder">
      <button @click="calculate">Multiply</button>
    </div>

    <hr/>

    <div style="text-align: center">
      <div style="color:red" v-if="validationErrors.length">
          <ul>
            <li :key="z" v-for="(error, z) in validationErrors">
             {{error}}
            </li>
          </ul>
      </div>
      <h3>Result</h3>

      <h6 v-if="loading" style="color:blue">Loading .....</h6>
      <div   :key="i" v-for="(mat,i) in result">
        <cell :readonly="true" :key="m"  :value="m" v-for="m in mat">
        </cell>
      </div>
    </div>

  </div>
</template>

<script>
  import Matrix from "./Matrix";
  import Cell from "./Cell";
  import axios from 'axios';
  export default {
      data() {
          return {
              first: [],
              second: [],
              result: [
                  [0,0],
                  [0,0]
              ],
              validationErrors: [],
              loading: false
          }
      },
      computed: {
        formatErrors(error) {
            return error.replace(['[', '"', ']']);
        }
      },
      components: {
          Matrix,
          Cell
      },
      methods: {
          updateMatrixOne (value) {
              this.first = value;
          },
          updateMatrixTwo (value) {
              this.second = value;
          },
          calculate () {
              if(!this.validate()) {
                  this.validationErrors.push(
                      'The columns on the first matrix must equal the rows on the second matrix');
                  return ;
              }
              this.loading = true;
              this.validationErrors = [];
              axios.post(location.origin+'/api/matrix/multiply', {
                  "first_matrix": this.first,
                  "second_matrix": this.second
              }).then(
                  (result) => {
                      this.result = result.data.data;
                      this.loading = false;
                  },
                  (error) => {
                      this.loading = false;
                      let errors = error.response.data.errors;
                     for( error in errors){
                         let _errors = errors[error];
                         for(let i = 0; i < _errors.length; i++) {
                             this.validationErrors.push(_errors[i]);
                         }

                     }

                     console.log(this.validationErrors)
                  }
              )
          },
          validate () {
              let column_of_first_matrix = this.first[0].length;
              let row_of_second_matrix = this.second.length;
              return column_of_first_matrix === row_of_second_matrix;
          }
      }
  }
</script>


<style scoped>
  .calculator {
    width: 80%;
    margin: auto;
    margin-bottom: 20px;
  }
  p {

  }

  .btn-holder {
    text-align: center;
  }

  button {
    border: 2px solid rgba(100, 189, 249);
    padding: 10px 20px;
    border-radius: 20px;
    background: rgba(100, 189, 249, 0.9);
    color:white;
    font-size: 20px;
    cursor: pointer;


  }

  .matrix-holder {
    display: inline-block;
    width:49%;
    margin: auto
  }

  button:hover {
    color: rgba(100, 189, 249, 0.9);
    background: white;
  }
  button:active, button:focus {
    border-color: white;
    outline: none;
  }

  h3 {
    color: dodgerblue;
    text-align: center;
  }

  hr {
    background:rgba(100, 189, 249, 0.9);
  }

  #heading {
    text-align: center;
  }

  ul {
    list-style-type: none;
  }
</style>
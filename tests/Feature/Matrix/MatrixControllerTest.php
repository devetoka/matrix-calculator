<?php


namespace Tests\Feature\Matrix;


use App\Http\Response\ApiResponse;
use App\Services\MatrixService;
use Tests\BaseTestCase;

class MatrixControllerTest extends BaseTestCase
{
    protected function setUp(): void
    {
//        $this->withoutExceptionHandling();
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @test
     * Condition: The number of columns of the first matrix must be equal
     * to the number of columns of the second matrix
     */
    public function returns_validation_errors_if_matrix_condition_is_not_met()
    {
        $response = $this->post('api/matrix/multiply', $this->invalidData());
        $response->assertStatus(ApiResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertSee
            ('The number of columns on the first matrix must equal the number of rows on the second matrix');
    }

    /**
     * @test
     * test that validation error is returned if keys are absent
     */
    public function returns_validation_errors_if_required_keys_are_absent()
    {
        $response = $this->post('api/matrix/multiply', []);
        $response->assertStatus(ApiResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertSee
            ('is required');
    }


    /**
     * @test
     * test that validation error is returned if request is malformed
     */
    public function returns_validation_errors_if_request_is_malformed()
    {
        $response = $this->post('api/matrix/multiply', [
            'first_matrix' => 'random',
            'second_matrix' => 'random',
        ]);
        $response->assertStatus(ApiResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response
            ->assertSee
            ('must be an array');
    }

    /**
     * @test
     * test that a successful response is returned if validation passed
     */
    public function can_multiply_matrices()
    {
        $response = $this->post('api/matrix/multiply',$this->validData());
        $response->assertOk();

    }

    /**
     * @test
     * test that a valid result is sent
     * condition: the result should have the same number of rows as the first matrix
     * and the same number of columns as the second matrix
     */
    public function returns_valid_result()
    {
        $response = $this->post('api/matrix/multiply',$this->validData());
        $response->assertOk();
        $response = json_decode($response->getContent());
        $this->assertIsArray($response->data);

        //check if returned result has the same rows as the first matrix
        $this->assertSame(
            count($this->validData()['first_matrix']),
            count($response->data)
        );

        //check if returned result has same columns as the second matrix
        $this->assertSame(
            count($this->validData()['second_matrix'][0]),
            count($response->data[0])
        );
    }


    /**
     * @test
     * checks if the result returned are alphabets
     */

    public function result_contains_only_alphabets()
    {
        $response = $this->post('api/matrix/multiply',$this->validData());
        $response->assertOk();
        $response = json_decode($response->getContent());
        $this->assertIsArray($response->data);
        foreach ($response->data as $row){
            foreach ($row as $column){
                $this->assertIsNotNumeric($column);
            }
        }

    }

    /**
     * @test
     * condition: each element in the matrix returned must match the following format
     * A => 1
     * Z => 26
     * AA => 27
     *
     */

    public function check_that_returned_alphabets_match_condition()
    {
        $alphabets = $this->alpha_formatter();
        $matrices = $this->validData();
        $result = MatrixService::multiply($matrices['first_matrix'], $matrices['second_matrix'], false);
        $rows = $result;
        $num_rows = count($rows);
        for($i = 0; $i < $num_rows; $i++){
            $columns = $rows[$i];
            $num_columns = count($columns);
            for($j = 0; $j < $num_columns; $j++){
                $this->assertSame(
                    $alphabets[MatrixService::printAlpha($result[$i][$j])],
                    $result[$i][$j]
                );
            }
        }

    }

    private function invalidData()
    {
        return [
            'first_matrix' => [
                [1,2],
            ],
            'second_matrix' => [
                [1,5,6,3],
                [2,1,1,4],
                [1,2,3,1]
            ]
        ];
    }

    private function validData()
    {
        return [
            'first_matrix' => [
                [1,2,3],
                [2,1,4]
            ],
            'second_matrix' => [
                [1,5,6,3],
                [2,1,1,4],
                [1,2,3,1]
            ]
        ];
    }

    private function alpha_formatter()
    {
        $alphas = [];
        for($i = 0; $i < 702; $i++)
        {
            $alphas[MatrixService::printAlpha($i+1)] = $i + 1;
        }
        return $alphas;
    }

}
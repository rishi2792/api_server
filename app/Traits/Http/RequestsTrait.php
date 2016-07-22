<?php namespace App\Traits\Http;

trait RequestsTrait {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @todo Move code that generates JSON response out of the controller class.
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        $actionName = $this->route()->getActionName();
        $controllerName = strstr($actionName, '@', true);
        $controller = \App::make($controllerName);

        return $controller->respondWithCollectionJsonUnprocessableEntity($errors);
    }

};
# GambiEl Response Query
> Usage for filtering on multidimational array by skeleton array
## Install
```
composer require igordrangel/gambiel-response-query
```

### Usage
```bash
$query = ["id" => ""];
$data = ResponseQuery::new(
    ResponseQuery::add("id","1")
    ResponseQuery::add("name","Igor")
    ResponseQuery::add("status",true)
);
$result = ResponseQuery::query($data, $query);
printr($result); // ["id" => "1"]
```
> You can use for quering request API by Header
```bash
class BancosController{
    /**
     * @Route("/users", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function get(Request $request): Response {
        $params = $request->query->all();
        $skeleton = json_decode($request->headers->get('query') ?? '', true);
        $result = [
            "users" => []
        ];
        
        // Here you can use your permission service to validate if can return a data or not
        $showEmail = false;
        
        foreach ($this->userRepository->Search() as $user) {
            array_push($result['users'], ResponseQuery::query(
                ResponseQuery::new(
                    ResponseQuery::add("id",$user->getId()),
                    ResponseQuery::add("name",$user->getName()),
                    ResponseQuery::add("email",$user->getEmail(), $showEmail),
                    ResponseQuery::add("status",$user->getStatus())
                ), 
                $skeleton
            ));
        }
    }
}
```

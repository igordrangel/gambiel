# GambiEl
> Usage for filtering on multidimational array by skeleton array
## Install
```
composer require igordrangel/gambiel
```

### Usage
```bash
$query = ["id" => ""];
$data = GambiEl::new(
    GambiEl::add("id","1")
    GambiEl::add("name","Igor")
    GambiEl::add("status",true)
);
$result = GambiEl::query($data, $query);
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
            array_push($result['users'], GambiEl::query(
                GambiEl::new(
                    GambiEl::add("id",$user->getId()),
                    GambiEl::add("name",$user->getName()),
                    GambiEl::add("email",$user->getEmail(), $showEmail),
                    GambiEl::add("status",$user->getStatus())
                ), 
                $skeleton
            ));
        }
    }
}
```
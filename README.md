# GambiEl

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
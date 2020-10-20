<?php
	namespace GambiEl\Helpers;
	
	class ResponseQuery {
		/**
		 * Filter data by query Array
		 * @param array $data Data creating by new method on GambiEl.new
		 * @param array|null $query
		 * @return array
		 * @link https://github.com/igordrangel/gambiel/blob/master/README.md
		 */
		public static function query(array $data, array $query = null): array {
			if (is_array($query)) {
				foreach ($data as $indexDado => $dado) {
					if (empty($query) && is_array($dado)) {
						if (!empty(current($dado)) && is_array(current($dado))) {
							foreach ($dado as $item) {
								if (empty($query)) {
									$data[$indexDado] = [];
									if (!empty(array_key_first($item))) {
										array_push($data[$indexDado], [
											array_key_first($item) => current($item)
										]);
									}
								} else {
									$data[$indexDado] = self::query($item, $query[$indexDado] ? $query[$indexDado] : null);
								}
							}
						} else {
							if (!empty(array_key_first($dado))) {
								$data[$indexDado] = [
									array_key_first($dado) => current($dado)
								];
							}
						}
					} else {
						if (is_array($dado) && array_key_exists($indexDado, $query)) {
							if (is_array(current($dado))) {
								$data[$indexDado] = [];
								foreach ($dado as $item) {
									array_push($data[$indexDado], self::query($item, $query[$indexDado] ? $query[$indexDado] : null));
								}
							} else {
								$data[$indexDado] = self::query($dado, $query[$indexDado] ? $query[$indexDado] : null);
							}
						} else {
							if (!empty($query) && !array_key_exists($indexDado, $query)) {
								unset($data[$indexDado]);
							}
						}
					}
				}
			}
			
			return $data;
		}
		
		/**
		 * Create array for quering on GabiEl::query
		 * @param array $data List items add by GambiEl::add
		 * @return array
		 * @link https://github.com/igordrangel/gambiel/blob/master/README.md
		 */
		public static function new(array ...$data): array {
			$dadosParaMerge = [];
			foreach ($data as $value) {
				foreach ($value as $index => $item) {
					$dadosParaMerge[$index] = $item;
				}
			}
			return array_filter(array_merge($dadosParaMerge), function ($var): bool { return $var !== '!!not-allowed!!'; });
		}
		
		/**
		 * Add item on array
		 * @param string $name
		 * @param $value
		 * @param bool $havePermission Permission to show this value on return
		 * @return array
		 * @link https://github.com/igordrangel/gambiel/blob/master/README.md
		 */
		public static function add(string $name, $value, bool $havePermission = true): array {
			return [$name => $havePermission ? $value : '!!not-allowed!!'];
		}
	}

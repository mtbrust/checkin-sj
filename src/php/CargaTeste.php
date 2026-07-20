<?php

class CargaTeste
{
    private $bdLogins;
    private $bdVisitantes;
    private $bdPresencas;
    private $userIds = [];
    private $cadastroIdx = 0;
    private $visitantesInseridos = [];
    private $resumo = [
        'usuarios' => 0,
        'visitantes' => 0,
        'presencas' => 0,
        'presenca_sem_cadastro' => 0,
        'cadastros_corrigidos' => 0,
    ];

    public function executar()
    {
        $this->bdLogins = new BdLogins();
        $this->bdVisitantes = new BdVisitantes();
        $this->bdPresencas = new BdPresencas();

        $this->criarUsuarios();
        $this->carregarIdsUsuarios();
        $this->criarVisitantes();
        $this->validarCadastrosComUsuario();
        $this->criarPresencas();

        return $this->resumo;
    }

    private function criarUsuarios()
    {
        $nomes = [
            'ANA TESTE SILVA',
            'BRUNO TESTE SOUZA',
            'CARLA TESTE LIMA',
            'DANIEL TESTE ROCHA',
            'ELISA TESTE MENDES',
        ];

        foreach ($nomes as $i => $nome) {
            $num = $i + 1;
            $cpf = '9900000000' . $num;
            $id = $this->bdLogins->insert([
                'fullName' => $nome,
                'firstName' => explode(' ', $nome)[0],
                'lastName' => explode(' ', $nome)[2] ?? 'TESTE',
                'userName' => 'teste' . $num,
                'email' => 'teste' . $num . '@sj.test',
                'telefone' => '3599900100' . $num,
                'cpf' => $cpf,
                'senha' => '123456',
                'obs' => 'Carga de teste.',
                'idLoginCreate' => 1,
                'dtCreate' => $this->dataAleatoria(7),
            ]);

            if ($id) {
                $this->userIds[] = (int) $id;
                $this->resumo['usuarios']++;
            }
        }
    }

    private function carregarIdsUsuarios()
    {
        $ids = [];
        $logins = $this->bdLogins->selectAll(500);

        if ($logins) {
            foreach ($logins as $login) {
                if ((int) ($login['idStatus'] ?? 1) === 1) {
                    $ids[] = (int) $login['id'];
                }
            }
        }

        if (!$ids) {
            $ids = [1];
        }

        $this->userIds = array_values(array_unique($ids));
    }

    private function validarCadastrosComUsuario()
    {
        foreach ($this->visitantesInseridos as $idx => $idVisitante) {
            $cadastro = $this->bdVisitantes->selectById($idVisitante);
            if (!$cadastro) {
                continue;
            }

            $idLogin = (int) ($cadastro['idLoginCreate'] ?? 0);
            if (in_array($idLogin, $this->userIds, true)) {
                continue;
            }

            $this->bdVisitantes->update($idVisitante, [
                'idLoginCreate' => $this->usuarioLoginId($idx),
            ]);
            $this->resumo['cadastros_corrigidos']++;
        }
    }

    private function criarVisitantes()
    {
        if (!$this->userIds) {
            $this->userIds = [1];
        }

        // 10 cadastros completos — 5 homens e 5 mulheres.
        for ($i = 1; $i <= 10; $i++) {
            $sexo = $i % 2 === 0 ? 'F' : 'M';
            $this->inserirVisitante([
                'pulseira' => 8000 + $i,
                'tpulseira' => $i % 2 === 0 ? 'AZUL' : 'AMARELA',
                'fullName' => ($sexo === 'M' ? 'HOMEM TESTE ' : 'MULHER TESTE ') . $i,
                'name' => $sexo === 'M' ? 'HOMEM' : 'MULHER',
                'sexo' => $sexo,
                'telefone' => '3599709' . str_pad((string) (8000 + $i), 4, '0', STR_PAD_LEFT),
                'cidade' => 'CIDADE TESTE',
                'bairro' => 'BAIRRO ' . $i,
                'endereco' => 'RUA TESTE ' . $i,
                'nascimento' => (2000 + $i) . '-0' . (($i % 9) + 1) . '-15',
                'status' => 1,
                'calouro' => $i <= 3 ? 'SIM' : 'NAO',
            ]);
        }

        // 3 cadastros duplicados (mesma pulseira).
        foreach ([8001, 8002, 8003] as $pulseira) {
            $this->inserirVisitante([
                'pulseira' => $pulseira,
                'tpulseira' => 'AZUL',
                'fullName' => 'DUPLICADO PULSEIRA ' . $pulseira,
                'name' => 'DUPLICADO',
                'sexo' => 'M',
                'telefone' => '3599708000' . $pulseira,
                'cidade' => 'CIDADE TESTE',
                'status' => 1,
            ]);
        }

        // 1 cadastro incompleto.
        $this->inserirVisitante([
            'pulseira' => 8011,
            'tpulseira' => 'AMARELA',
            'fullName' => '',
            'name' => '',
            'status' => 1,
        ]);

        // 1 cadastro de cada status.
        foreach ([1 => 8012, 2 => 8013, 3 => 8014, 4 => 8015] as $status => $pulseira) {
            $this->inserirVisitante([
                'pulseira' => $pulseira,
                'tpulseira' => $status % 2 === 0 ? 'AZUL' : 'AMARELA',
                'fullName' => 'STATUS ' . $status . ' TESTE',
                'name' => 'STATUS',
                'sexo' => $status % 2 === 0 ? 'F' : 'M',
                'telefone' => '359970801' . $status,
                'cidade' => 'CIDADE TESTE',
                'bairro' => 'BAIRRO STATUS',
                'status' => $status,
            ]);
        }

        // Extras para testes adicionais.
        $extras = [
            ['pulseira' => 8016, 'palco' => 'SIM', 'fullName' => 'PALCO TESTE UM', 'sexo' => 'F'],
            ['pulseira' => 8017, 'palco' => 'SIM', 'fullName' => 'PALCO TESTE DOIS', 'sexo' => 'M'],
            ['pulseira' => 8018, 'calouro' => 'SIM', 'fullName' => 'CALOURO TESTE', 'sexo' => 'F', 'oldPulseira' => 7001],
            ['pulseira' => 8019, 'fullName' => 'VISITANTE EXTRA UM', 'sexo' => 'M', 'religiao' => 'IGREJA TESTE'],
            ['pulseira' => 8020, 'fullName' => 'VISITANTE EXTRA DOIS', 'sexo' => 'F', 'whatsapp' => 'SIM'],
        ];

        foreach ($extras as $idx => $extra) {
            $this->inserirVisitante(array_merge([
                'tpulseira' => $idx % 2 === 0 ? 'AMARELA' : 'AZUL',
                'name' => 'EXTRA',
                'telefone' => '359970802' . ($idx + 1),
                'cidade' => 'POUSO ALEGRE',
                'bairro' => 'CENTRO',
                'endereco' => 'RUA EXTRA ' . ($idx + 1),
                'nascimento' => '1998-05-20',
                'status' => 1,
            ], $extra));
        }

        // Visitantes com 4, 5 e 6 dias únicos de presença (para badge da pesquisa).
        $presencaDias = [
            ['pulseira' => 8104, 'tpulseira' => 'AMARELA', 'dias' => 4, 'fullName' => 'PRESENCA 4 DIAS TESTE', 'sexo' => 'M'],
            ['pulseira' => 8105, 'tpulseira' => 'AZUL', 'dias' => 5, 'fullName' => 'PRESENCA 5 DIAS TESTE', 'sexo' => 'F'],
            ['pulseira' => 8106, 'tpulseira' => 'AMARELA', 'dias' => 6, 'fullName' => 'PRESENCA 6 DIAS TESTE', 'sexo' => 'M'],
        ];

        foreach ($presencaDias as $item) {
            $this->inserirVisitante([
                'pulseira' => $item['pulseira'],
                'tpulseira' => $item['tpulseira'],
                'fullName' => $item['fullName'],
                'name' => 'PRESENCA',
                'sexo' => $item['sexo'],
                'telefone' => '35997081' . $item['dias'] . '0' . $item['dias'],
                'cidade' => 'CIDADE TESTE',
                'bairro' => 'BAIRRO DIAS',
                'endereco' => 'RUA ' . $item['dias'] . ' DIAS',
                'nascimento' => '2001-07-20',
                'status' => 1,
            ]);
        }
    }

    private function criarPresencas()
    {
        $diaTripla = $this->dataNoDia(3);
        $diaDuplicada = $this->dataNoDia(2);

        // 1 presença triplicada (mesma pulseira, mesmo dia).
        for ($i = 0; $i < 3; $i++) {
            $this->inserirPresenca(8001, 'AMARELA', $diaTripla, $i);
        }

        // 3 presenças duplicadas (2 registros no mesmo dia para cada pulseira).
        foreach ([8002, 8003, 8004] as $idx => $pulseira) {
            $cor = $pulseira % 2 === 0 ? 'AZUL' : 'AMARELA';
            $this->inserirPresenca($pulseira, $cor, $diaDuplicada, $idx);
            $this->inserirPresenca($pulseira, $cor, $diaDuplicada, $idx + 1);
        }

        // Completar presenças distribuídas nos últimos dias.
        $pulseiras = [8005, 8006, 8007, 8008, 8009, 8010, 8012, 8013, 8016];
        foreach ($pulseiras as $idx => $pulseira) {
            $cor = $pulseira % 2 === 0 ? 'AZUL' : 'AMARELA';
            $this->inserirPresenca($pulseira, $cor, $this->dataNoDia($idx % 8), $idx);
        }

        // 4, 5 e 6 dias únicos (com 1 duplicata no último dia para validar DISTINCT).
        $casosDias = [
            ['pulseira' => 8104, 'tpulseira' => 'AMARELA', 'dias' => 4],
            ['pulseira' => 8105, 'tpulseira' => 'AZUL', 'dias' => 5],
            ['pulseira' => 8106, 'tpulseira' => 'AMARELA', 'dias' => 6],
        ];

        foreach ($casosDias as $caso) {
            for ($d = 0; $d < $caso['dias']; $d++) {
                $this->inserirPresenca($caso['pulseira'], $caso['tpulseira'], $this->dataNoDia($d), $d);
            }
            // Duplicata no dia mais recente — não deve aumentar o contador de dias.
            $this->inserirPresenca($caso['pulseira'], $caso['tpulseira'], $this->dataNoDia(0), 99);
        }

        // 1 presença sem cadastro (pulseira inexistente).
        if ($this->inserirPresenca(9099, 'AZUL', $this->dataNoDia(0), 0)) {
            $this->resumo['presenca_sem_cadastro'] = 1;
        }
    }

    private function inserirVisitante(array $data)
    {
        $fields = array_merge([
            'obs' => 'Carga de teste.',
            'idStatus' => 1,
            'idLoginCreate' => $this->usuarioLoginId($this->cadastroIdx),
            'dtCreate' => $this->dataAleatoria(7),
        ], $data);

        $this->cadastroIdx++;

        $id = $this->bdVisitantes->insert($fields);
        if ($id) {
            $this->visitantesInseridos[] = (int) $id;
            $this->resumo['visitantes']++;
        }

        return $id;
    }

    private function inserirPresenca($pulseira, $tpulseira, $dataBase, $userIdx = 0)
    {
        $dt = new DateTime($dataBase);
        $dt->modify('+' . rand(0, 180) . ' minutes');

        $id = $this->bdPresencas->insert([
            'pulseira' => $pulseira,
            'tpulseira' => $tpulseira,
            'obs' => 'Carga de teste.',
            'idLoginCreate' => $this->usuarioLoginId($userIdx),
            'dtCreate' => $dt->format('Y-m-d H:i:s'),
        ]);

        if ($id) {
            $this->resumo['presencas']++;
        }

        return $id;
    }

    private function usuarioLoginId($index)
    {
        if (!$this->userIds) {
            return 1;
        }

        $pos = abs((int) $index) % count($this->userIds);
        return $this->userIds[$pos];
    }

    private function dataAleatoria($diasAtrasMax = 7)
    {
        $dias = rand(0, (int) $diasAtrasMax);
        $dt = new DateTime('today');
        $dt->modify('-' . $dias . ' days');
        $dt->setTime(rand(8, 21), rand(0, 59), rand(0, 59));

        return $dt->format('Y-m-d H:i:s');
    }

    private function dataNoDia($diasAtras)
    {
        $dt = new DateTime('today');
        $dt->modify('-' . (int) $diasAtras . ' days');
        $dt->setTime(10, 0, 0);

        return $dt->format('Y-m-d H:i:s');
    }
}

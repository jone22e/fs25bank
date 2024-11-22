WebBankScript = {}

-- URL para enviar os dados
local url = "https://fs25.flexi.ltd/api.php"

-- Diretório do mod
WebBankScript.dir = g_currentModDirectory
WebBankScript.modName = g_currentModName

-- Função principal chamada ao carregar o mapa
function WebBankScript:loadMap()
    print("[WebBankScript] Mod carregado com sucesso!")
    self:enviarDadosDasFazendas()
end

-- Função chamada ao mudar o dia no jogo
function WebBankScript:onDayChanged()
    print("[WebBankScript] Dia mudou! Enviando dados das fazendas...")
    self:enviarDadosDasFazendas()
end

-- Função para enviar os dados das fazendas
function WebBankScript:enviarDadosDasFazendas()
    local dadosFazendas = {}

    -- Iterar sobre todas as fazendas registradas
    for _, farm in pairs(g_farmManager.farms) do
        table.insert(dadosFazendas, {
            nome = farm.name,
            saldo = farm.money
        })
    end

    -- Converter os dados para JSON
    local jsonDados = self:converterParaJSON(dadosFazendas)

    -- Enviar os dados via HTTP
    local http = require("socket.http")
    local ltn12 = require("ltn12")

    local resposta = {}
    local _, status = http.request{
        url = url,
        method = "POST",
        headers = {
            ["Content-Type"] = "application/json",
            ["Content-Length"] = tostring(#jsonDados)
        },
        source = ltn12.source.string(jsonDados),
        sink = ltn12.sink.table(resposta)
    }

    if status == 200 then
        print("[WebBankScript] Dados enviados com sucesso!")
    else
        print("[WebBankScript] Erro ao enviar os dados: " .. tostring(status))
    end
end

-- Função para converter tabela para JSON
function WebBankScript:converterParaJSON(tabela)
    local json = "["
    for i, item in ipairs(tabela) do
        json = json .. string.format('{"nome":"%s","saldo":%.2f}', item.nome, item.saldo)
        if i < #tabela then
            json = json .. ","
        end
    end
    json = json .. "]"
    return json
end

-- Registrar os eventos
addModEventListener(WebBankScript)

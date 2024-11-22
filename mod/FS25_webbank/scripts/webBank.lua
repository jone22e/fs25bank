WebBankScript = {}

local url = "https://fs25.flexi.ltd/api.php"

function WebBankScript:loadMap(name)
    print("Mod de envio de dados das fazendas carregado!")
    self:enviarDadosDasFazendas()
end

function WebBankScript:onDayChanged()
    print("Dia no jogo mudou! Enviando dados das fazendas...")
    self:enviarDadosDasFazendas()
end

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
        print("Dados enviados com sucesso!")
    else
        print("Erro ao enviar os dados: " .. tostring(status))
    end
end

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

addModEventListener(WebBankScript)

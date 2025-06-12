// api/frete.js
export default function handler(req, res) {
  // Permite requisições CORS de qualquer origem (ou especifique o domínio)
  res.setHeader('Access-Control-Allow-Origin', '*'); 
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  // Permite que o navegador faça a requisição OPTIONS (preflight)
  if (req.method === 'OPTIONS') {
    res.status(200).end();
    return;
  }

  // Seu código normal de API aqui
  if (req.method === 'POST') {
    // Processa a requisição
  } else {
    res.status(405).json({ message: 'Method not allowed' });
  }
}

export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Método não permitido, use POST' });
  }

  const { cep, peso, largura, altura, comprimento } = req.body;

  // Validação simples do CEP
  if (!cep || cep.length !== 8 || !/^\d{8}$/.test(cep)) {
    return res.status(400).json({ error: 'CEP inválido' });
  }

  // Aqui você pode colocar sua lógica real de cálculo de frete
  // Por enquanto, vamos simular uma resposta fixa:
  const fretes = [
    { tipo: 'PAC', prazo: '7 dias', preco: 20.50 },
    { tipo: 'SEDEX', prazo: '3 dias', preco: 35.00 },
  ];

  // Retorna um JSON com as opções de frete
  return res.status(200).json({ cep, fretes });
}

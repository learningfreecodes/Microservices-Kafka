# Challenge


Estamos procurando um desenvolvedor back-end sênior para se juntar à nossa equipe e ajudar a criar e gerenciar nossos micro-serviços em PHP (Laravel). Este teste técnico tem como objetivo avaliar suas habilidades técnicas nessas áreas.

## Instruções Gerais

Crie três micro-serviços separados usando Laravel: Produto, Pedido e Integração com Shopify.
Os serviços devem se comunicar entre si conforme necessário.

Implemente autenticação JWT ou OAuth 2.0 para os micro-serviços.

Escreva testes unitários e de integração para os micro-serviços.

### Micro-Serviço de Produto

Implemente um endpoint para a criação de um novo produto. O produto deve ter, no mínimo, um nome, uma descrição e um preço.
 
Implemente um endpoint para listar todos os produtos disponíveis.

Implemente um endpoint para atualizar as informações de um produto existente.

### Micro-Serviço de Pedido

Implemente um endpoint para a criação de um novo pedido. O pedido deve fazer referência a um ou mais produtos.

Implemente um endpoint para listar todos os pedidos realizados.

### Micro-Serviço de Integração

Implemente uma funcionalidade que sincroniza a lista de produtos entre o micro-serviço de Produto e a loja Shopify. A sincronização deve ocorrer quando um produto é criado, atualizado ou excluído no micro-serviço de Produto.

Implemente uma funcionalidade que sincroniza a lista de pedidos entre a loja Shopify e o micro-serviço de Pedido. A sincronização deve ocorrer quando um pedido é feito na loja Shopify.

Implemente um sistema de manuseio de erros robusto para lidar com possíveis falhas na comunicação entre os micro-serviços e a loja Shopify.

Implemente logs que rastreiem todas as ações realizadas pelo micro-serviço de Integração com Shopify.



# Solução

1 - Gerando certificado ssl para trabalhar local usando mkcerts

Instalação no seu ambiente no seguinte link:
[text](https://github.com/FiloSottile/mkcert?ref=knp-backend.ghost.io)


cd /nginx/certs
mkcert -key-file hubii.local.key.pem -cert-file hubii.local.pem localhost hubbi.local "*.local" 127.0.0.1 ::1

Atualizar hosts

```
sudo sh -c 'echo "127.0.0.1 *.local" >> /etc/hosts'
```

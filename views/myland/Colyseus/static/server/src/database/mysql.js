const { rejects } = require('assert')
const fs = require('fs')
const mysqlConnection = require('mysql')

const data = fs.readFileSync('./.gitigonore/database.json')
const conf = JSON.parse(data)


class Mysql {
    static instance;
    mysql;
    constructor() { }

    static getInstance() {
        if (!Mysql.instance) {
            Mysql.instance = new Mysql();
        }

        return Mysql.instance;
    }

    init() {
        Mysql.getInstance().mysql = mysqlConnection.createPool({
            host: conf.host,
            user: conf.user,
            password: conf.password,
            port: conf.port,
            database: conf.database,
            connectionLimit: 100
        });

        // Mysql.getInstance().mysql.connect(err => {
        //     if (err) {
        //         console.log("mysql err", err);
        //     }
        //     else {
        //         console.log("mysql connect");
        //     }
        // })
    }

    async query(sql) {
        return new Promise(function(resolve,reject) {
            Mysql.getInstance().mysql.getConnection((err,connection) => {
                if(err) {
                    throw err;
                } else {
                    connection.query(sql, (err, result) => {
                        connection.release();

                        if (err) {
                            console.log("query_!!!!!ERROR!!!!!!");
                            reject(err);
                        }
                        else {
                            resolve(result);
                        }
                    });
                    
                }
            });
        })
    }

    async insertUpdateQuery(inserUpdatetSql,dataInsert) {
        return new Promise(function(resolve,reject) {
            Mysql.getInstance().mysql.getConnection((err,connection) => {
                if(err) {
                    throw err;
                } else {
                    connection.query(inserUpdatetSql, dataInsert,(err, result) => {
                        connection.release();
                        if (err) {
                            console.log("insertUpdateQuery_!!!!!ERROR!!!!!!");
                            reject(err);
                        }
                        else {
                            resolve(result);
                        }
                    });
                    
                }
            });
        })
    }

    
}

exports.Mysql = Mysql;

//mysql.end()
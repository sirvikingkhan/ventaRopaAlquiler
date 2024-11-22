/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100420
 Source Host           : localhost:3306
 Source Schema         : venta_ropa

 Target Server Type    : MySQL
 Target Server Version : 100420
 File Encoding         : 65001

 Date: 27/01/2024 11:51:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for almacen
-- ----------------------------
DROP TABLE IF EXISTS `almacen`;
CREATE TABLE `almacen`  (
  `idAlmacen` int NOT NULL AUTO_INCREMENT,
  `idEmpresa` int NOT NULL DEFAULT 1,
  `codigoAlm` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ubicacion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ciudad` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `entrada` time(0) NOT NULL,
  `salida` time(0) NOT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`idAlmacen`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for alquiler
-- ----------------------------
DROP TABLE IF EXISTS `alquiler`;
CREATE TABLE `alquiler`  (
  `idAlquiler` int NOT NULL AUTO_INCREMENT,
  `idCliente` int NULL DEFAULT NULL,
  `idAlmacen` int NULL DEFAULT NULL,
  `idDocAlm` int NULL DEFAULT NULL,
  `cSerie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cNumCom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cInstitucion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `cdirInstitucion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tFecEnt` date NULL DEFAULT NULL,
  `tFecDev` date NULL DEFAULT NULL,
  `cContac` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cObsDet` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nTotal` decimal(10, 2) NULL DEFAULT NULL,
  `cEstRep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '0 - Alquiler Pagando | 1 - Alquiler Pagando | 2 - Alquiler Devuelto | 3 - Anulado',
  `cEstado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idCaja` int NULL DEFAULT NULL,
  `cCodUsu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tModifi` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`idAlquiler`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for alquiler_detalle
-- ----------------------------
DROP TABLE IF EXISTS `alquiler_detalle`;
CREATE TABLE `alquiler_detalle`  (
  `idAlquilerDetalle` int NOT NULL AUTO_INCREMENT,
  `idAlquiler` int NULL DEFAULT NULL,
  `codigo_producto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `total_pago` decimal(10, 2) NULL DEFAULT NULL,
  `fecha_alquiler` date NULL DEFAULT NULL,
  PRIMARY KEY (`idAlquilerDetalle`) USING BTREE,
  INDEX `idAlquiler`(`idAlquiler`) USING BTREE,
  CONSTRAINT `alquiler_detalle_ibfk_1` FOREIGN KEY (`idAlquiler`) REFERENCES `alquiler` (`idAlquiler`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for bitacora_credito
-- ----------------------------
DROP TABLE IF EXISTS `bitacora_credito`;
CREATE TABLE `bitacora_credito`  (
  `idBit` int NOT NULL AUTO_INCREMENT,
  `idCliente` int NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `montod` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`idBit`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bitacora_credito
-- ----------------------------

-- ----------------------------
-- Table structure for caja
-- ----------------------------
DROP TABLE IF EXISTS `caja`;
CREATE TABLE `caja`  (
  `idCaja` int NOT NULL AUTO_INCREMENT,
  `fecha_apertura` datetime(0) NOT NULL,
  `fecha_cierre` datetime(0) NOT NULL,
  `monto_apertura` float NOT NULL,
  `monto_ingreso` float NOT NULL,
  `monto_egreso` float NOT NULL,
  `monto_cierre` float NOT NULL,
  `idUsuario` int NOT NULL,
  `idAlmacen` int NOT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`idCaja`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 66 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for categoria
-- ----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria`  (
  `idCategoria` int NOT NULL AUTO_INCREMENT,
  `desCat` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `estadoCat` int NOT NULL,
  PRIMARY KEY (`idCategoria`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `dni` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nombres` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `limite_credito` float(6, 2) NOT NULL,
  `credito_usado` float(6, 2) NOT NULL,
  PRIMARY KEY (`idCliente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for compra
-- ----------------------------
DROP TABLE IF EXISTS `compra`;
CREATE TABLE `compra`  (
  `idCompra` int NOT NULL AUTO_INCREMENT,
  `idProveedor` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idDocalmacen` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `num_documento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `serie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtotal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `igv` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_compra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tipo_pago` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `codigo_transa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `contacto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int NOT NULL DEFAULT 0,
  `fecha_venta` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idCompra`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for cotizacion
-- ----------------------------
DROP TABLE IF EXISTS `cotizacion`;
CREATE TABLE `cotizacion`  (
  `idCotizacion` int NOT NULL AUTO_INCREMENT,
  `cNuDoci` int NULL DEFAULT NULL,
  `cNomCli` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `cTelCli` int NULL DEFAULT NULL,
  `cDirCli` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `idAlmacen` int NULL DEFAULT NULL,
  `idUsuario` int NULL DEFAULT NULL,
  `cTipDoc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `cNroDoc` int NULL DEFAULT NULL,
  `cSerie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nSubTotal` float(6, 2) NULL DEFAULT NULL,
  `nIgv` float(6, 2) NULL DEFAULT NULL,
  `nTotal` float(6, 2) NULL DEFAULT NULL,
  `cEstado` int NULL DEFAULT NULL,
  `fecha_cotizacion` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`idCotizacion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for deposito
-- ----------------------------
DROP TABLE IF EXISTS `deposito`;
CREATE TABLE `deposito`  (
  `idDeposito` int NOT NULL AUTO_INCREMENT,
  `idProducto` int NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`idDeposito`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for detalle_compra
-- ----------------------------
DROP TABLE IF EXISTS `detalle_compra`;
CREATE TABLE `detalle_compra`  (
  `idDetalleCompra` int NOT NULL AUTO_INCREMENT,
  `idCompra` int NOT NULL,
  `codigo_producto` bigint NOT NULL,
  `cantidad` float NOT NULL,
  `total_compra` float NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idDetalleCompra`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for detalle_cotizacion
-- ----------------------------
DROP TABLE IF EXISTS `detalle_cotizacion`;
CREATE TABLE `detalle_cotizacion`  (
  `idDetalleCotizacion` int NOT NULL AUTO_INCREMENT,
  `idCotizacion` int NULL DEFAULT NULL,
  `idProducto` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `totalcoti` float(6, 2) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`idDetalleCotizacion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of detalle_cotizacion
-- ----------------------------
INSERT INTO `detalle_cotizacion` VALUES (14, 13, 2125, 2, 1.00, '2023-08-13 09:13:17');
INSERT INTO `detalle_cotizacion` VALUES (15, 13, 2124, 2, 3.00, '2023-08-13 09:13:17');
INSERT INTO `detalle_cotizacion` VALUES (16, 14, 2124, 1, 1.50, '2023-08-13 09:15:22');
INSERT INTO `detalle_cotizacion` VALUES (17, 15, 2124, 1, 1.50, '2023-08-13 09:15:42');
INSERT INTO `detalle_cotizacion` VALUES (18, 16, 1902, 10, 69.00, '2023-09-02 12:59:34');
INSERT INTO `detalle_cotizacion` VALUES (19, 17, 1903, 3, 27.00, '2023-09-09 01:02:35');
INSERT INTO `detalle_cotizacion` VALUES (20, 17, 1902, 1, 6.90, '2023-09-09 01:02:35');
INSERT INTO `detalle_cotizacion` VALUES (21, 18, 1907, 3, 90.00, '2023-09-12 07:12:17');
INSERT INTO `detalle_cotizacion` VALUES (22, 18, 1905, 1, 29.90, '2023-09-12 07:12:17');
INSERT INTO `detalle_cotizacion` VALUES (23, 18, 1902, 1, 6.90, '2023-09-12 07:12:17');
INSERT INTO `detalle_cotizacion` VALUES (24, 19, 2030, 4, 70.00, '2023-11-07 03:09:42');
INSERT INTO `detalle_cotizacion` VALUES (25, 19, 1907, 4, 120.00, '2023-11-07 03:09:42');
INSERT INTO `detalle_cotizacion` VALUES (26, 19, 1902, 5, 34.50, '2023-11-07 03:09:42');
INSERT INTO `detalle_cotizacion` VALUES (27, 20, 1910, 5, 190.00, '2023-11-07 03:10:26');
INSERT INTO `detalle_cotizacion` VALUES (28, 21, 1911, 3, 59.70, '2023-11-28 18:46:14');
INSERT INTO `detalle_cotizacion` VALUES (29, 21, 1909, 1, 10.00, '2023-11-28 18:46:14');
INSERT INTO `detalle_cotizacion` VALUES (30, 22, 2392, 1, 6.00, '2023-12-07 05:21:31');
INSERT INTO `detalle_cotizacion` VALUES (31, 23, 2397, 1, 2100.00, '2023-12-07 08:29:06');
INSERT INTO `detalle_cotizacion` VALUES (32, 24, 2397, 1, 2100.00, '2023-12-07 08:30:00');
INSERT INTO `detalle_cotizacion` VALUES (33, 24, 2392, 1, 6.00, '2023-12-07 08:30:00');
INSERT INTO `detalle_cotizacion` VALUES (34, 24, 1908, 1, 20.00, '2023-12-07 08:30:00');
INSERT INTO `detalle_cotizacion` VALUES (35, 25, 2398, 1, 3200.00, '2023-12-07 15:39:30');
INSERT INTO `detalle_cotizacion` VALUES (36, 26, 1956, 8, 176.00, '2023-12-25 12:29:17');
INSERT INTO `detalle_cotizacion` VALUES (37, 26, 1913, 1, 32.00, '2023-12-25 12:29:17');
INSERT INTO `detalle_cotizacion` VALUES (38, 27, 1903, 1, 9.00, '2023-12-26 07:47:29');
INSERT INTO `detalle_cotizacion` VALUES (39, 28, 1905, 1, 29.90, '2023-12-26 07:48:15');
INSERT INTO `detalle_cotizacion` VALUES (40, 29, 2398, 1, 3200.00, '2024-01-03 13:44:31');
INSERT INTO `detalle_cotizacion` VALUES (41, 30, 1902, 1, 6.90, '2024-01-12 02:10:50');
INSERT INTO `detalle_cotizacion` VALUES (42, 31, 1903, 1, 9.00, '2024-01-12 09:43:32');

-- ----------------------------
-- Table structure for docalmacen
-- ----------------------------
DROP TABLE IF EXISTS `docalmacen`;
CREATE TABLE `docalmacen`  (
  `idDocalmacen` int NOT NULL AUTO_INCREMENT,
  `idAlmacen` int NOT NULL,
  `Documento` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Serie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Cantidad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Fecha_registro` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `cTipDoc` int NULL DEFAULT 1,
  PRIMARY KEY (`idDocalmacen`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for empleado
-- ----------------------------
DROP TABLE IF EXISTS `empleado`;
CREATE TABLE `empleado`  (
  `idEmpleado` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(9) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dni` varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecNacimiento` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `foto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEmpleado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of empleado
-- ----------------------------
INSERT INTO `empleado` VALUES (3, 'Aut aspernat', 'Qui quaerat ', 'A velit a', 'Mollit volup', '74', 'sakytody@mailinator.com', '2008-12-07', 'views/img/empleado/default/avatar4.png');
-- ----------------------------
-- Table structure for empresa
-- ----------------------------
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa`  (
  `idEmpresa` int NOT NULL AUTO_INCREMENT,
  `logo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ruc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `razon_social` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `moneda` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `simbolom` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `impuesto` float(6, 2) NOT NULL,
  PRIMARY KEY (`idEmpresa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for inventario
-- ----------------------------
DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario`  (
  `idInventario` int NOT NULL AUTO_INCREMENT,
  `idAlmacen` int NOT NULL,
  `idProducto` int NOT NULL,
  `stock` float NOT NULL,
  `stock_minimo` int NOT NULL,
  `fecha_verificar` date NULL DEFAULT NULL,
  `idUsuario` int NOT NULL,
  PRIMARY KEY (`idInventario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4206 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for kardex
-- ----------------------------
DROP TABLE IF EXISTS `kardex`;
CREATE TABLE `kardex`  (
  `idKardex` int NOT NULL AUTO_INCREMENT,
  `fecha_registro` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stock` int NOT NULL,
  `idProducto` int NOT NULL,
  `idAlmacen` int NOT NULL,
  `idUsuario` int NOT NULL,
  `tipo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` int NOT NULL,
  `habia` int NOT NULL,
  `hay` int NOT NULL,
  PRIMARY KEY (`idKardex`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 118 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus`  (
  `idMenu` int NOT NULL AUTO_INCREMENT,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acronimo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `grupo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idMenu`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 76 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES (1, 'Ver almacen', 'veralmacen', 'A. Almacen');
INSERT INTO `menus` VALUES (2, 'Agregar almacen', 'agralmacen', 'A. Almacen');
INSERT INTO `menus` VALUES (3, 'Editar almacen', 'editalmacen', 'A. Almacen');
INSERT INTO `menus` VALUES (4, 'Eliminar almacen', 'elimalmacen', 'A. Almacen');
INSERT INTO `menus` VALUES (5, 'Ver empleado', 'verempleado', 'B. Empleado');
INSERT INTO `menus` VALUES (6, 'Agregar empleado', 'agrempleado', 'B. Empleado');
INSERT INTO `menus` VALUES (7, 'Editar empleado', 'editempleado', 'B. Empleado');
INSERT INTO `menus` VALUES (8, 'Eliminar empleado', 'elimempleado', 'B. Empleado');
INSERT INTO `menus` VALUES (9, 'Ver usuarios', 'verusuarios', 'C. Usuarios');
INSERT INTO `menus` VALUES (10, 'Agregar usuarios', 'agrusuarios', 'C. Usuarios');
INSERT INTO `menus` VALUES (11, 'Editar usuarios', 'editusuarios', 'C. Usuarios');
INSERT INTO `menus` VALUES (12, 'Eliminar usuarios', 'elimusuarios', 'C. Usuarios');
INSERT INTO `menus` VALUES (13, 'Ver proveedor', 'verprov', 'D. Proveedor');
INSERT INTO `menus` VALUES (14, 'Agregar proveedor', 'agrprov', 'D. Proveedor');
INSERT INTO `menus` VALUES (15, 'Editar proveedor', 'editprov', 'D. Proveedor');
INSERT INTO `menus` VALUES (16, 'Eliminar proveedor', 'elimprov', 'D. Proveedor');
INSERT INTO `menus` VALUES (21, 'Ver perfil', 'verperfil', 'F. Perfil');
INSERT INTO `menus` VALUES (22, 'Agregar perfil', 'agrperfil', 'F. Perfil');
INSERT INTO `menus` VALUES (23, 'Editar perfil', 'editperfil', 'F. Perfil');
INSERT INTO `menus` VALUES (24, 'Eliminar perfil', 'elimperfil', 'F. Perfil');
INSERT INTO `menus` VALUES (25, 'Ver categoria', 'vercat', 'G. Categoria');
INSERT INTO `menus` VALUES (26, 'Agregar categoria', 'agrcat', 'G. Categoria');
INSERT INTO `menus` VALUES (27, 'Editar categoria', 'editcat', 'G. Categoria');
INSERT INTO `menus` VALUES (28, 'Eliminar categoria', 'elimcat', 'G. Categoria');
INSERT INTO `menus` VALUES (29, 'Ver producto', 'verproduc', 'H. Producto');
INSERT INTO `menus` VALUES (30, 'Agregar producto', 'agrproduc', 'H. Producto');
INSERT INTO `menus` VALUES (31, 'Editar producto', 'editproduc', 'H. Producto');
INSERT INTO `menus` VALUES (32, 'Eliminar producto', 'elimproduc', 'H. Producto');
INSERT INTO `menus` VALUES (33, 'Ver inventario', 'verinv', 'I. Inventario');
INSERT INTO `menus` VALUES (34, 'Agregar inventario', 'agrinv', 'I. Inventario');
INSERT INTO `menus` VALUES (35, 'Sumar inventario', 'suminv', 'I. Inventario');
INSERT INTO `menus` VALUES (36, 'Ajustar inventario', 'ajusinv', 'I. Inventario');
INSERT INTO `menus` VALUES (37, 'Trasladar inventario', 'trasinv', 'I. Inventario');
INSERT INTO `menus` VALUES (38, 'Eliminar inventario', 'eliminv', 'I. Inventario');
INSERT INTO `menus` VALUES (39, 'Ver kardex', 'verkardex', 'I. Inventario');
INSERT INTO `menus` VALUES (40, 'Ver central', 'vercent', 'J. Almacen Central');
INSERT INTO `menus` VALUES (41, 'Agregar central', 'agrcent', 'J. Almacen Central');
INSERT INTO `menus` VALUES (42, 'Sumar central', 'sumcent', 'J. Almacen Central');
INSERT INTO `menus` VALUES (43, 'Ajustar central', 'ajuscent', 'J. Almacen Central');
INSERT INTO `menus` VALUES (44, 'Trasladar central', 'trascent', 'J. Almacen Central');
INSERT INTO `menus` VALUES (45, 'Eliminar central', 'elimcent', 'J. Almacen Central');
INSERT INTO `menus` VALUES (46, 'Nueva compra', 'nuevacompra', 'K. Compra y Venta');
INSERT INTO `menus` VALUES (47, 'Ver compra', 'vercompra', 'K. Compra y Venta');
INSERT INTO `menus` VALUES (48, 'Anular compra', 'anulcompra', 'K. Compra y Venta');
INSERT INTO `menus` VALUES (49, 'Nueva venta', 'nuevaventa', 'K. Compra y Venta');
INSERT INTO `menus` VALUES (50, 'Ver venta', 'verventa', 'K. Compra y Venta');
INSERT INTO `menus` VALUES (51, 'Anular venta', 'anulventa', 'K. Compra y Venta');
INSERT INTO `menus` VALUES (52, 'Ver comprobante', 'vercomprob', 'L. Comprobante');
INSERT INTO `menus` VALUES (53, 'Agregar comprobante', 'agrcomprob', 'L. Comprobante');
INSERT INTO `menus` VALUES (54, 'Editar comprobante', 'editcomprob', 'L. Comprobante');
INSERT INTO `menus` VALUES (55, 'Eliminar comprobante', 'elimcomprob', 'L. Comprobante');
INSERT INTO `menus` VALUES (56, 'Ver caja', 'vercaja', 'M. Caja');
INSERT INTO `menus` VALUES (57, 'Aperturar caja', 'apercaja', 'M. Caja');
INSERT INTO `menus` VALUES (58, 'Ingreso caja', 'ingcaja', 'M. Caja');
INSERT INTO `menus` VALUES (59, 'Egreso caja', 'egrcaja', 'M. Caja');
INSERT INTO `menus` VALUES (60, 'Detalle caja', 'detcaja', 'M. Caja');
INSERT INTO `menus` VALUES (61, 'Cerrar caja', 'cerracaja', 'M. Caja');
INSERT INTO `menus` VALUES (62, 'Ver cliente', 'vercli', 'N. Cliente');
INSERT INTO `menus` VALUES (63, 'Agregar cliente', 'agrcli', 'N. Cliente');
INSERT INTO `menus` VALUES (64, 'Editar cliente', 'editcli', 'N. Cliente');
INSERT INTO `menus` VALUES (65, 'Eliminar cliente', 'elimcli', 'N. Cliente');
INSERT INTO `menus` VALUES (66, 'Pagar credito', 'pagcre', 'N. Cliente');
INSERT INTO `menus` VALUES (67, 'Ver historial', 'verhst', 'N. Cliente');
INSERT INTO `menus` VALUES (68, 'Ver Configuracion', 'verconf', 'Ñ. Configuracion');
INSERT INTO `menus` VALUES (69, 'Editar Configuracion', 'editconf', 'Ñ. Configuracion');
INSERT INTO `menus` VALUES (70, 'Producto Bajo Inv.', 'verprodbi', 'H. Producto');
INSERT INTO `menus` VALUES (71, 'Ver Cotizacion', 'vercoti', 'I. Cotizacion');
INSERT INTO `menus` VALUES (72, 'Crear Cotizacion', 'nuevacoti', 'I. Cotizacion');
INSERT INTO `menus` VALUES (73, 'Productos Verificar', 'veriprod', 'H. Producto');
INSERT INTO `menus` VALUES (74, 'Alquiler ', 'alquiler', 'O. Alquiler');
INSERT INTO `menus` VALUES (75, 'Reporte Mov.', 'reportemov', 'P. Reporte');

-- ----------------------------
-- Table structure for movimientos_caja
-- ----------------------------
DROP TABLE IF EXISTS `movimientos_caja`;
CREATE TABLE `movimientos_caja`  (
  `idMovCaja` int NOT NULL AUTO_INCREMENT,
  `idCaja` int NOT NULL,
  `fecha` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `tipo` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `monto` float NOT NULL,
  `idUsuario` int NOT NULL,
  PRIMARY KEY (`idMovCaja`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for notificacion
-- ----------------------------
DROP TABLE IF EXISTS `notificacion`;
CREATE TABLE `notificacion`  (
  `idNotificacion` int NOT NULL AUTO_INCREMENT,
  `idAlmacen` int NULL DEFAULT NULL,
  `idProducto` int NULL DEFAULT NULL,
  `tipo` int NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `cantidad` int NULL DEFAULT NULL,
  `estado` int NULL DEFAULT NULL,
  PRIMARY KEY (`idNotificacion`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for pago_alquiler
-- ----------------------------
DROP TABLE IF EXISTS `pago_alquiler`;
CREATE TABLE `pago_alquiler`  (
  `idPagoAlquiler` int NOT NULL AUTO_INCREMENT,
  `idAlquiler` int NULL DEFAULT NULL,
  `metodo_pago` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `monto_pago` decimal(10, 2) NULL DEFAULT NULL,
  `nro_ope` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `idCaja` int NULL DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `fecha_pago` date NULL DEFAULT NULL,
  PRIMARY KEY (`idPagoAlquiler`) USING BTREE,
  INDEX `idAlquiler`(`idAlquiler`) USING BTREE,
  CONSTRAINT `pago_alquiler_ibfk_1` FOREIGN KEY (`idAlquiler`) REFERENCES `alquiler` (`idAlquiler`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for pago_credito
-- ----------------------------
DROP TABLE IF EXISTS `pago_credito`;
CREATE TABLE `pago_credito`  (
  `idPagoc` int NOT NULL AUTO_INCREMENT,
  `idCliente` int NOT NULL,
  `metodo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `monto` float(6, 2) NOT NULL,
  `fecha` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `idCaja` int NOT NULL,
  PRIMARY KEY (`idPagoc`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for pago_venta
-- ----------------------------
DROP TABLE IF EXISTS `pago_venta`;
CREATE TABLE `pago_venta`  (
  `idPagoV` int NOT NULL AUTO_INCREMENT,
  `idVenta` int NOT NULL,
  `metodo_pago` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `monto_pago` float(6, 2) NOT NULL,
  `nro_ope` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `estado` int NOT NULL,
  `fecha_pago` datetime(0) NOT NULL,
  PRIMARY KEY (`idPagoV`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for perfil
-- ----------------------------
DROP TABLE IF EXISTS `perfil`;
CREATE TABLE `perfil`  (
  `idPerfil` int NOT NULL AUTO_INCREMENT,
  `descPerfil` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `veralmacen` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agralmacen` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editalmacen` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimalmacen` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verempleado` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrempleado` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editempleado` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimempleado` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verusuarios` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrusuarios` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editusuarios` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimusuarios` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verprov` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrprov` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editprov` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimprov` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verservicio` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrservicio` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editservicio` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimservicio` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verperfil` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrperfil` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editperfil` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimperfil` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vercat` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrcat` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editcat` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimcat` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verproduc` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrproduc` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editproduc` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimproduc` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verinv` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrinv` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `suminv` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ajusinv` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `trasinv` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `eliminv` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verkardex` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verdep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrdep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `sumdep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ajusdep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `trasdep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimdep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nuevacompra` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vercompra` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `anulcompra` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `nuevaventa` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verventa` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `anulventa` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vercomprob` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrcomprob` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editcomprob` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimcomprob` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vercaja` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `apercaja` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `ingcaja` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `egrcaja` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `detcaja` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cerracaja` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vercita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `impcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `servcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `pagcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `impbolcita` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verhm` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `atenderhm` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `vercm` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `atendercm` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verorden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrorden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `editorden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimorden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `resulorden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `pagorden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `imporden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `impborden` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verconejo` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verraza` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verrecep` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verproceso` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `impproceso` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimproceso` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `verhab` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `agrhab` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `edithab` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `elimhab` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `manthab` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`idPerfil`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for perfiles
-- ----------------------------
DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE `perfiles`  (
  `idPerfiles` int NOT NULL AUTO_INCREMENT,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`idPerfiles`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for permiso
-- ----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso`  (
  `idPermiso` int NOT NULL AUTO_INCREMENT,
  `idPerfiles` int NOT NULL,
  `idMenu` int NOT NULL,
  `estado` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`idPermiso`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 195 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for producto
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto`  (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `descProducto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ubicacion` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `codigoBarras` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idCategoria` int NOT NULL,
  `precioCompra` float NOT NULL,
  `precioVenta` float NOT NULL,
  `precioVentaMA` float NOT NULL,
  `oferta` float NOT NULL,
  `tipoProducto` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`idProducto`) USING BTREE,
  INDEX `idx_idProducto`(`idProducto`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2399 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for producto2
-- ----------------------------
DROP TABLE IF EXISTS `producto2`;
CREATE TABLE `producto2`  (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `descProducto` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `codigoBarras` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ubicacion` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idCategoria` int NOT NULL,
  `precioCompra` float NOT NULL,
  `precioVenta` float NOT NULL,
  `precioVentaMA` float NOT NULL,
  `oferta` float NOT NULL,
  `tipoProducto` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`idProducto`) USING BTREE,
  INDEX `idx_idProducto`(`idProducto`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1845 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores`  (
  `idProveedor` int NOT NULL AUTO_INCREMENT,
  `RUC` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `celular` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefono` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idProveedor`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `idEmpleado` int NOT NULL,
  `idAlmacen` int NOT NULL,
  `login` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `passlogin` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `controlt` int NULL DEFAULT NULL,
  `idPerfil` int NOT NULL,
  `estado` int NOT NULL,
  `ultimo_login` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idUsuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for venta_cabecera
-- ----------------------------
DROP TABLE IF EXISTS `venta_cabecera`;
CREATE TABLE `venta_cabecera`  (
  `idVenta` int NOT NULL AUTO_INCREMENT,
  `idCliente` int NULL DEFAULT NULL,
  `idAlmacen` int NOT NULL,
  `idUsuario` int NOT NULL,
  `idDocalmacen` int NOT NULL,
  `serie` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nro_comprobante` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `subtotal` float NOT NULL,
  `igv` float NOT NULL,
  `delivery` float NOT NULL,
  `descuento` float(6, 2) NULL DEFAULT NULL,
  `total_venta` float(6, 2) NULL DEFAULT NULL,
  `estado` int NOT NULL DEFAULT 0,
  `idCaja` int NOT NULL,
  `fecha_venta` timestamp(0) NOT NULL DEFAULT current_timestamp(0),
  PRIMARY KEY (`idVenta`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for venta_detalle
-- ----------------------------
DROP TABLE IF EXISTS `venta_detalle`;
CREATE TABLE `venta_detalle`  (
  `idDetalle` int NOT NULL AUTO_INCREMENT,
  `idVenta` int NOT NULL,
  `codigo_producto` bigint NOT NULL,
  `cantidad` float NOT NULL,
  `total_venta` float NOT NULL,
  `fecha_venta` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`idDetalle`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Procedure structure for prc_anular_compra
-- ----------------------------
DROP PROCEDURE IF EXISTS `prc_anular_compra`;
delimiter ;;
CREATE PROCEDURE `prc_anular_compra`(IN `p_idCompra` VARCHAR(8))
BEGIN
DECLARE v_idProducto VARCHAR(20);
DECLARE v_codigo VARCHAR(20);
DECLARE v_cantidad FLOAT;
DECLARE v_idUsuario VARCHAR(20);
DECLARE v_stock FLOAT;


DECLARE done INT DEFAULT FALSE;
DECLARE cursor_i CURSOR FOR 

SELECT p.idProducto, codigo_producto,cantidad, c.idUsuario, d.stock
FROM detalle_compra dc INNER JOIN compra c
ON dc.idCompra = c.idCompra
INNER JOIN producto p 
ON dc.codigo_producto = p.codigoBarras
INNER JOIN deposito d 
ON p.idProducto = d.idProducto
where CAST(dc.idCompra AS CHAR CHARACTER SET utf8)  = CAST(p_idCompra AS CHAR CHARACTER SET utf8) ;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

OPEN cursor_i;
read_loop: LOOP
FETCH cursor_i INTO v_idProducto, v_codigo, v_cantidad,v_idUsuario, v_stock;

	IF done THEN
	  LEAVE read_loop;
	END IF;
    
    UPDATE deposito as d INNER JOIN producto as p ON d.idProducto = p.idProducto SET d.stock = d.stock -  v_cantidad
     WHERE CAST(p.codigoBarras AS CHAR CHARACTER SET utf8) = CAST(v_codigo AS CHAR CHARACTER SET utf8);
                                                            
                                                            
    UPDATE  compra SET estado = 1 WHERE CAST(idCompra AS CHAR CHARACTER SET utf8) = CAST(p_idCompra AS CHAR CHARACTER SET utf8) ;
    INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Anulacion compra',v_cantidad ,v_idProducto,'0',v_idUsuario ,'Salida',1, v_stock,  v_cantidad - v_stock);
			
 

END LOOP;
CLOSE cursor_i;

SELECT 'Se anulo correctamente la compra';
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for prc_anular_venta
-- ----------------------------
DROP PROCEDURE IF EXISTS `prc_anular_venta`;
delimiter ;;
CREATE PROCEDURE `prc_anular_venta`(IN `p_idVenta` VARCHAR(8))
BEGIN
/*CREATE DEFINER=`root`@`localhost` PROCEDURE `prc_anular_venta`(IN `p_idVenta` VARCHAR(8), p_idUsuario int)*/

DECLARE v_codigo VARCHAR(20);
DECLARE v_cantidad FLOAT;
DECLARE v_almacen FLOAT;
DECLARE v_total_venta FLOAT;
DECLARE v_stock VARCHAR(20);
DECLARE v_idproducto VARCHAR(20);
DECLARE done INT DEFAULT FALSE;
DECLARE cursor_i CURSOR FOR 

SELECT vd.codigo_producto,vd.cantidad, vc.idAlmacen, vc.total_venta, vc.tipo_pago, i.stock, i.idProducto
FROM venta_detalle vd 
INNER JOIN venta_cabecera vc
ON vd.idVenta = vc.idVenta
INNER JOIN producto p
ON p.codigoBarras = vd.codigo_producto
INNER JOIN inventario i
ON i.idProducto = p.idProducto
where CAST(vd.idVenta AS CHAR CHARACTER SET utf8)  = CAST(p_idVenta AS CHAR CHARACTER SET utf8) ;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

OPEN cursor_i;
read_loop: LOOP
FETCH cursor_i INTO v_codigo, v_cantidad, v_almacen, v_total_venta , v_stock, v_idproducto;

	IF done THEN
	  LEAVE read_loop;
	END IF;
    
    UPDATE inventario as i INNER JOIN producto as p ON i.idProducto = p.idProducto SET i.stock = i.stock + v_cantidad
     WHERE CAST(p.codigoBarras AS CHAR CHARACTER SET utf8) = CAST(v_codigo AS CHAR CHARACTER SET utf8) AND
      i.idAlmacen = CAST(v_almacen AS CHAR CHARACTER SET utf8)  ;
                                       

		UPDATE  venta_cabecera SET estado = 1 WHERE CAST(idVenta AS CHAR CHARACTER SET utf8) = CAST(p_idVenta AS CHAR CHARACTER SET utf8) ;
		UPDATE  pago_venta SET estado = 1 WHERE CAST(idVenta AS CHAR CHARACTER SET utf8) = CAST(p_idVenta AS CHAR CHARACTER SET utf8) ;
        
    INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
													VALUES ('Anulacion venta',v_cantidad ,v_idproducto, v_almacen ,1 ,'Entrada',1, v_stock,  v_cantidad + v_stock);
    
END LOOP;
CLOSE cursor_i;

SELECT 'Se anulo correctamente la venta';
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for pruebaproc
-- ----------------------------
DROP PROCEDURE IF EXISTS `pruebaproc`;
delimiter ;;
CREATE PROCEDURE `pruebaproc`(IN `P_id_Venta` INT)
BEGIN
 SELECT vc.idVenta,
da.Documento, 
vc.serie, 
vc.nro_comprobante,  
concat(em.nombres,' ',em.apellidos) as empleado,
vc.tipo_pago,
vc.codigo_transa,
vc.contacto, 
CONCAT('S./ ',CONVERT(ROUND(vc.total_venta,2), CHAR)) as total_venta,
CONCAT('S./ ',CONVERT(ROUND(vc.subtotal,2), CHAR)) as subtotal,
CONCAT('S./ ',CONVERT(ROUND(vc.igv,2), CHAR)) as igv,
vc.total_venta as totalventaletras,
vc.estado, 
vc.fecha_venta
FROM venta_cabecera vc
INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
where vc.idVenta= P_id_Venta;

END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for ReporteCaja
-- ----------------------------
DROP PROCEDURE IF EXISTS `ReporteCaja`;
delimiter ;;
CREATE PROCEDURE `ReporteCaja`(IN `P_id_Caja` INT, IN `P_fecha` VARCHAR(20))
BEGIN

SELECT 
IFNULL(LPAD(max(c.idCaja),8,'0'),'00000001') nroCaja ,
    c.fecha_apertura, 
    concat(em.nombres,' ',em.apellidos) as empleado,
		emp.*,
		a.descripcion,
		a.ubicacion,
    
    IFNULL(ROUND(sum(c.monto_apertura),2),0.00) as montoApertura, 

		IFNULL((SELECT ROUND(SUM(A.monto_pago),2) FROM pago_venta A 
		INNER JOIN venta_cabecera B ON A.idVenta = B.idVenta
		WHERE A.metodo_pago = 'Efectivo'
		AND B.estado = 0
		AND DATE(B.fecha_venta) = DATE(P_fecha)
	  AND B.idCaja = P_id_Caja), 0.00) AS TotalVentas,
		
		IFNULL((select ROUND(sum(pc.monto),2)
    from pago_credito pc 
    WHERE pc.metodo = 'Efectivo'
    AND DATE(pc.fecha) = DATE(P_fecha) 
    AND pc.idCaja = P_id_Caja ),0.00) as TotalAbono, 

    IFNULL((select ROUND(sum(mc.monto),2) 
    from movimientos_caja mc 
    WHERE mc.tipo = 'Ingreso'
    AND DATE(mc.fecha) = DATE(P_fecha) 
    AND mc.idCaja = P_id_Caja ),0.00) as Ingreso,

    IFNULL((select ROUND(sum(mc.monto),2) 
    from movimientos_caja mc 
    WHERE mc.tipo = 'Egreso' 
    AND DATE(mc.fecha) = DATE(P_fecha)
    AND mc.idCaja = P_id_Caja ),0.00) as Egreso,

    IFNULL(ROUND(sum(c.monto_cierre),2),0.00) as montoCierre,
    		
		IFNULL((SELECT ROUND(SUM(A.monto_pago),2) FROM pago_venta A 
		INNER JOIN venta_cabecera B ON A.idVenta = B.idVenta
		WHERE A.metodo_pago = 'Tarjeta'
		AND B.estado = 0
		AND DATE(B.fecha_venta) = DATE(P_fecha)
	  AND B.idCaja = P_id_Caja), 0.00) AS TotalVentasTarjeta,
    		
		IFNULL((SELECT ROUND(SUM(A.monto_pago),2) FROM pago_venta A 
		INNER JOIN venta_cabecera B ON A.idVenta = B.idVenta
		WHERE A.metodo_pago = 'Transferencia'
		AND B.estado = 0
		AND DATE(B.fecha_venta) = DATE(P_fecha)
	  AND B.idCaja = P_id_Caja), 0.00) AS TotalVentasTrans,
    	
		IFNULL((SELECT ROUND(SUM(A.monto_pago),2) FROM pago_venta A 
		INNER JOIN venta_cabecera B ON A.idVenta = B.idVenta
		WHERE A.metodo_pago = 'Yape'
		AND B.estado = 0
		AND DATE(B.fecha_venta) = DATE(P_fecha)
	  AND B.idCaja = P_id_Caja), 0.00) AS TotalVentasYape,
        
		IFNULL((SELECT ROUND(SUM(A.monto_pago),2) FROM pago_venta A 
		INNER JOIN venta_cabecera B ON A.idVenta = B.idVenta
		WHERE A.metodo_pago = 'Plin'
		AND B.estado = 0
		AND DATE(B.fecha_venta) = DATE(P_fecha)
	  AND B.idCaja = P_id_Caja), 0.00) AS TotalVentasPlin,
			
		IFNULL((SELECT ROUND(sum(vd.total_venta/vd.cantidad - p.precioCompra),2) as ganancias
		FROM venta_detalle vd
		INNER JOIN venta_cabecera vc
		ON vc.idVenta = vd.idVenta
		INNER JOIN producto p
		ON p.codigoBarras = vd.codigo_producto
		WHERE DATE(vd.fecha_venta) = DATE (P_fecha) 
		AND vc.idCaja = P_id_Caja),0.00) as TotalGanancias
		
                  
FROM caja c
INNER JOIN usuario us
ON c.idUsuario = us.idUsuario
INNER JOIN empleado em
ON us.idEmpleado = em.idEmpleado
INNER JOIN almacen a
ON c.idAlmacen= a.idAlmacen
INNER JOIN empresa emp
ON emp.idEmpresa= a.idEmpresa
WHERE c.idCaja = P_id_Caja
AND  DATE(c.fecha_apertura)= date(P_fecha);
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for SP_REGISTRAR_CITA
-- ----------------------------
DROP PROCEDURE IF EXISTS `SP_REGISTRAR_CITA`;
delimiter ;;
CREATE PROCEDURE `SP_REGISTRAR_CITA`(IN `IDUSUARIO` INT, IN `FECHA` DATE, IN `HORA` TIME, IN `IDCONEJO` INT, IN `ATENDER` TEXT, IN `IDALMACEN` INT)
BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT count(*) from cita where fecha_cita=FECHA and hora_cita = HORA);
IF  @CANTIDAD=0 THEN
INSERT INTO cita(idUsuario,fecha_cita,hora_cita,idConejo,atender,idAlmacen)
VALUES(IDUSUARIO,FECHA,HORA,IDCONEJO,ATENDER,IDALMACEN);
SELECT LAST_INSERT_ID();
END IF;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;

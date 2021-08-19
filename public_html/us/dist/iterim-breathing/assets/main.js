(this["webpackJsonpbreathing-dots"] = this["webpackJsonpbreathing-dots"] || []).push([
    [0], {
        78: function(e, t, r) {},
        89: function(e, t, r) {
            "use strict";
            r.r(t);
            var a = r(8),
                n = r(1),
                s = r(62),
                c = r.n(s),
                i = r(50),
                o = r(15),
                l = (r(78), r(16)),
                u = r(18),
                h = r(5),
                j = r(72),
                f = r(37),
                d = r(63),
                b = r(29),
                m = r(64),
                p = r(65);
            Object(u.d)({
                EffectComposer: j.a,
                ShaderPass: f.a,
                SavePass: d.a,
                RenderPass: p.a
            });
            var v = {
                uniforms: {
                    tDiffuse1: {
                        value: null
                    },
                    tDiffuse2: {
                        value: null
                    },
                    tDiffuse3: {
                        value: null
                    }
                },
                vertexShader: "\n    varying vec2 vUv;\n    void main() {\n      vUv = uv;\n      gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1);\n    }\n  ",
                fragmentShader: "\n    varying vec2 vUv;\n    uniform sampler2D tDiffuse1;\n    uniform sampler2D tDiffuse2;\n    uniform sampler2D tDiffuse3;\n    \n    void main() {\n      vec4 del0 = texture2D(tDiffuse1, vUv);\n      vec4 del1 = texture2D(tDiffuse2, vUv);\n      vec4 del2 = texture2D(tDiffuse3, vUv);\n      // min alpha hides until all buffers are full\n      float alpha = min(min(del0.a, del1.a), del2.a);\n      gl_FragColor = vec4(del0.r, del1.g, del2.b, alpha);\n    }\n  "
            };

            function O() {
                var e = Object(n.useRef)(),
                    t = Object(n.useRef)(),
                    r = Object(n.useRef)(),
                    s = Object(n.useRef)(!1),
                    c = Object(u.g)(),
                    i = c.scene,
                    o = c.gl,
                    l = c.size,
                    j = c.camera,
                    f = Object(n.useMemo)((function() {
                        return {
                            rtA: new h.WebGLRenderTarget(l.width, l.height),
                            rtB: new h.WebGLRenderTarget(l.width, l.height)
                        }
                    }), [l]),
                    d = f.rtA,
                    p = f.rtB,
                    O = o.getPixelRatio();
                return Object(n.useEffect)((function() {
                    e.current.setSize(l.width, l.height)
                }), [l]), Object(u.f)((function() {
                    e.current.render();
                    var a = s.current ? p : d,
                        n = s.current ? d : p;
                    t.current.renderTarget = n, r.current.uniforms.tDiffuse2.value = a.texture, r.current.uniforms.tDiffuse3.value = n.texture, s.current = !s.current
                }), 1), Object(a.jsxs)("effectComposer", {
                    ref: e,
                    args: [o],
                    children: [Object(a.jsx)("renderPass", {
                        attachArray: "passes",
                        scene: i,
                        camera: j
                    }), Object(a.jsx)("shaderPass", {
                        attachArray: "passes",
                        ref: r,
                        args: [v, "tDiffuse1"],
                        needsSwap: !1
                    }), Object(a.jsx)("savePass", {
                        attachArray: "passes",
                        ref: t,
                        needsSwap: !0
                    }), Object(a.jsx)("shaderPass", {
                        attachArray: "passes",
                        args: [m.a],
                        "uniforms-resolution-value-x": 1 / (l.width * O),
                        "uniforms-resolution-value-y": 1 / (l.height * O)
                    }), Object(a.jsx)("shaderPass", {
                        attachArray: "passes",
                        args: [b.a]
                    })]
                })
            }
            var x = r(47),
                g = function(e, t, r, a) {
                    return 2 * r / Math.PI * Math.atan(Math.sin(2 * Math.PI * e * a) / t)
                };

            function M() {
                var e = Object(n.useRef)(),
                    t = Object(n.useMemo)((function() {
                        var e = new h.Vector3,
                            t = new h.Matrix4,
                            r = Object(l.a)(Array(1e4)).map((function(e, t) {
                                var r = new h.Vector3;
                                return r.x = t % 100 - 50, r.y = Math.floor(t / 100) - 50, r.y += t % 2 * .5, r.x += .3 * Math.random(), r.y += .3 * Math.random(), r
                            })),
                            a = new h.Vector3(1, 0, 0),
                            n = r.map((function(e) {
                                return e.length() + .5 * Math.cos(8 * e.angleTo(a))
                            }));
                        return {
                            vec: e,
                            transform: t,
                            positions: r,
                            distances: n
                        }
                    }), []),
                    r = t.vec,
                    s = t.transform,
                    c = t.positions,
                    i = t.distances;
                return Object(u.f)((function(t) {
                    for (var a = t.clock, n = 0; n < 1e4; ++n) {
                        var o = i[n],
                            l = a.elapsedTime - o / 25,
                            u = g(l, .15 + .2 * o / 72, .4, 1 / 3.8);
                        r.copy(c[n]).multiplyScalar(u + 1.3), s.setPosition(r), e.current.setMatrixAt(n, s)
                    }
                    e.current.instanceMatrix.needsUpdate = !0
                })), Object(a.jsxs)("instancedMesh", {
                    ref: e,
                    args: [null, null, 1e4],
                    children: [Object(a.jsx)("circleBufferGeometry", {
                        args: [.15]
                    }), " ", Object(a.jsx)("meshBasicMaterial", {}), " "]
                })
            }

            function y() {
                return Object(a.jsxs)(u.a, {
                    orthographic: !0,
                    camera: {
                        zoom: 20
                    },
                    colorManagement: !1,
                    resize: {
                        polyfill: x.a
                    },
                    children: [Object(a.jsx)("color", {
                        attach: "background",
                        args: ["black"]
                    }), Object(a.jsx)(O, {}), Object(a.jsx)(M, {})]
                })
            }
            var w = r(12),
                S = r(10),
                D = r(25),
                P = r(69),
                k = function(e) {
                    var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : .1,
                        r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 1,
                        a = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : .1;
                    return 2 * r / Math.PI * Math.atan(Math.sin(2 * Math.PI * e * a) / t)
                };

            function _(e) {
                var t = e.ticksSpring,
                    r = e.clickSpring,
                    s = (e.duration, Object(D.a)(e, ["ticksSpring", "clickSpring", "duration"])),
                    c = Object(n.useRef)(),
                    i = Object(n.useMemo)((function() {
                        var e = new h.Vector3,
                            t = new h.Matrix4;
                        return {
                            vec: e,
                            right: new h.Vector3(1, 0, 0),
                            transform: t,
                            vec3Mouse: new h.Vector3,
                            focus: new h.Vector3,
                            positions: Object(l.a)(Array(1e4)).map((function(e, t) {
                                var r = new h.Vector3;
                                return r.x = t % 100 - 50, r.y = Math.floor(t / 100) - 50, r.y += t % 2 * .5, r.x += .3 * Math.random(), r.y += .3 * Math.random(), r
                            }))
                        }
                    }), []),
                    o = i.vec,
                    j = i.right,
                    f = i.transform,
                    d = i.vec3Mouse,
                    b = i.focus,
                    m = i.positions;
                return Object(u.f)((function(e) {
                    var a = e.mouse,
                        n = e.viewport;
                    d.x = a.x * n.width / 2, d.y = a.y * n.height / 2;
                    for (var s = 0; s < 1e4; ++s) {
                        b.copy(d).multiplyScalar(r.get()), o.copy(m[s]).sub(b);
                        var i = o.length() + .5 * Math.cos(8 * o.angleTo(j)),
                            l = t.get() / 2 + .5 - i / 100,
                            u = k(l, .15 + .2 * i / 72, .4, 1);
                        o.multiplyScalar(u + 1.3).add(b), f.setPosition(o), c.current.setMatrixAt(s, f)
                    }
                    c.current.instanceMatrix.needsUpdate = !0
                })), Object(a.jsxs)("instancedMesh", Object(S.a)(Object(S.a)({
                    args: [null, null, 1e4],
                    ref: c
                }, s), {}, {
                    children: [Object(a.jsx)("circleBufferGeometry", {
                        args: [.15, 8]
                    }), Object(a.jsx)("meshBasicMaterial", {
                        color: "white"
                    })]
                }))
            }

            function R() {
                var e = Object(n.useState)(0),
                    t = Object(w.a)(e, 2),
                    r = t[0],
                    s = t[1],
                    c = Object(P.useSpring)({
                        ticksSpring: r,
                        clickSpring: r % 2 === 1 ? 1 : 0,
                        config: {
                            tension: 20,
                            friction: 20,
                            clamp: !0
                        }
                    }),
                    i = c.ticksSpring,
                    o = c.clickSpring,
                    l = {
                        onPointerDown: function(e) {
                            e.target.setPointerCapture(e.pointerId), s(r + 1)
                        },
                        onPointerUp: function() {
                            r % 2 === 1 && (o.get() > .5 ? s(r + 1) : s(r - 1))
                        }
                    };
                return Object(a.jsxs)(u.a, Object(S.a)(Object(S.a)({
                    orthographic: !0,
                    colorManagement: !1,
                    camera: {
                        position: [0, 0, 100],
                        zoom: 20
                    },
                    resize: {
                        polyfill: x.a
                    }
                }, l), {}, {
                    children: [Object(a.jsx)("color", {
                        attach: "background",
                        args: ["black"]
                    }), Object(a.jsx)(_, {
                        ticksSpring: i,
                        clickSpring: o,
                        duration: 3.8
                    }), Object(a.jsx)(O, {})]
                }))
            }

            function A() {
                return Object(a.jsxs)(i.a, {
                    basename: "/",
                    children: [Object(a.jsxs)("div", {
                        className: "frame",
                        children: [Object(a.jsxs)("h1", {
                            className: "frame__title",
                            children: [" ", Object(a.jsx)("a", {
                                href: "https://www.schedule35.com",
                                children: ""
                            }), "  ", Object(a.jsx)("br", {}), ""]
                        }), Object(a.jsxs)("div", {
                            className: "frame__links",
                            children: [Object(a.jsx)("a", {
                                href: "https://www.schedule35.com",
                                children: ""
                            }), Object(a.jsx)("a", {
                                href: "https://www.schedule35.com",
                                children: ""
                            }), Object(a.jsx)("a", {
                                href: "https://www.schedule35.com",
                                children: ""
                            })]
                        })]
                    }), Object(a.jsx)("div", {
                        className: "content",
                        children: Object(a.jsx)("h2", {
                            className: "content__title",
                            children: ""
                        })
                    }), Object(a.jsx)("div", {
                        id: "animation",
                        children: Object(a.jsxs)(o.d, {
                            children: [Object(a.jsx)(o.b, {
                                exact: !0,
                                path: "/start",
                                children: Object(a.jsx)(y, {})
                            }), Object(a.jsx)(o.b, {
                                exact: !0,
                                path: "/demo2",
                                children: Object(a.jsx)(R, {})
                            }), Object(a.jsx)(o.b, {
                                path: "*",
                                children: Object(a.jsx)(o.a, {
                                    to: "/start"
                                })
                            })]
                        })
                    })]
                })
            }
            c.a.render(Object(a.jsx)(A, {}), document.getElementById("root"))
        }
    },
    [
        [89, 1, 2]
    ]
]);
//# sourceMappingURL=main.7f85d67a.chunk.js.map